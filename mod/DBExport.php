<?php

/*
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://www.znetdk.fr
 * Copyright (C) 2025 Pascal MARTINEZ (contact@znetdk.fr)
 * License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * --------------------------------------------------------------------
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * --------------------------------------------------------------------
 * ZnetDK 4 Mobile DB Export module Manager class
 * 
 * File version: 1.0
 * Last update: 04/12/2025
 */

namespace z4m_dbexport\mod;

/**
 * Get data from App database
 */
class DBExport {

    /**
     * Generates an Excel Spreadsheet containing the data of the App's SQL
     * tables.
     * @param string $filePath Absolute file path of the Excel spreadsheet to
     * generate
     */
    static public function generateExcelFile($filePath) {
        $DBToExcelDataTypes = MOD_Z4M_DBEXPORT_MYSQLTOEXCEL_DATA_TYPES;
        $writer = new ExcelGenerator($filePath);
        $tablesDesc = self::getTablesDescription();
        foreach ($tablesDesc as $tableName => $tablesDesc) {
            $writer->setSheetName($tablesDesc['comment'] === '' ? $tableName : $tablesDesc['comment']);
            $header = [];
            foreach ($tablesDesc['columns'] as $columnName => $columnDesc) {
                $colHeaderName = $columnDesc['comment'] === '' ? $columnName : $columnDesc['comment'];
                $header[$colHeaderName] = key_exists($columnDesc['data_type'], $DBToExcelDataTypes) 
                        ? $DBToExcelDataTypes[$columnDesc['data_type']] : 'string';
            }
            $writer->setSheetHeader($header);
            self::processSQLTableDataRows($tableName, $tablesDesc['columns'], function($rowData, $context){
                $context[0]->addRowToSheet($rowData);
            }, [$writer]);
            $writer->write();
        }
        register_shutdown_function('unlink', $filePath);
    }
    
    /**
     * Returns the description of the SQL tables to export.
     * @return array Multidimensional array where each key is a SQL Table name.
     * For each SQL table, the array contains the SQL table comment and the
     * column description.
     * For example: 
     * [
     *  'mytable1' => [
     *      'comment' => 'My table 1',
     *      'columns' => [
     *          'col_1' => ['data_type' => 'varchar', 'comment' => 'Col 1'],
     *          'col_2' => ['data_type' => 'int', 'comment' => 'Col 2'],
     *      ]
     *  ],
     *  'mytable2' => ...
     * ]
     */
    static protected function getTablesDescription() {
        $dataDesc = [];
        $sqlTables = self::getSQLTables();        
        foreach ($sqlTables as $sqlTable) {
            $tableName = $sqlTable['table_name'];
            $dataDesc[$tableName] = ['comment' => $sqlTable['table_comment'], 'columns' => []];
            $columns = self::getSQLTableColumns($sqlTable['table_name']);
            foreach ($columns as $column) {
                $columnName = $column['column_name'];
                $dataDesc[$tableName]['columns'][$columnName] = [
                    'data_type' => $column['data_type'],
                    'comment' => $column['column_comment']
                ];
            }
        }
        return $dataDesc;
    }
    
    /**
     * Returns the SQL tables of the Application to export.
     * Only the SQL tables specified via the MOD_Z4M_DBEXPORT_SELECTED_TABLES
     * constant are selected.
     * If excluded SQL tables are specified via the 
     * MOD_Z4M_DBEXPORT_EXCLUDED_TABLES constant, all the SQL tables are 
     * returnedonly except those specified through this constant.
     * @return array Multidimensional array. Each array element is an
     * associative array whith the 'table_name' and 'table_comment' keys.
     * For example: [
     *      ['table_name' => 'mytable1', 'table_comment' => 'My table 1'],
     *      ['table_name' => 'mytable2', 'table_comment' => 'My table 2']
     * ]
     */
    static protected function getSQLTables() {        
        $dao = new model\TableDAO();
        $tablesFound = [];
        while ($row = $dao->getResult()) {
            $tablesFound[] = $row;
        }
        return $tablesFound;
    }
    
    /**
     * Returns the columns description of the specified SQL Table.
     * @param string $tableName The SQL table name.
     * @return array Multidimensional array. Each array element is an
     * associative array whith the 'column_name', 'data_type' and 
     * 'column_comment' keys.
     * For example: [
     *  ['column_name'=>'col1', 'data_type'=>'int', 'column_comment'=>'Col 1'],
     *  ['column_name'=>'col2', 'data_type'=>'int', 'column_comment'=>'Col 2']
     * ]
     */
    static protected function getSQLTableColumns($tableName) {
        $dao = new model\ColumnDAO();
        $dao->setTableNameAsFilter($tableName);
        $columnsFound = [];
        while ($row = $dao->getResult()) {
            $columnsFound[] = $row;
        }
        return $columnsFound;
    }
    
    /**
     * Fetch and process through a callback function, the rows of the specified
     * SQL table.
     * @param string $tableName The SQL table name
     * @param array $tableColumns The SQL table columns description.
     * @param function $callbackProcessor The callback function in charge of
     * processing the SQL table row.
     * @param array $callbackContext The context values required to the callback
     * function.
     */
    static protected function processSQLTableDataRows($tableName, $tableColumns, $callbackProcessor, $callbackContext) {
        $dao = new \SimpleDAO($tableName);
        while ($row = $dao->getResult()) {
            $rowData = [];
            foreach ($tableColumns as $columnName => $columnDesc) {
                if (key_exists($columnName, $row)) {
                    $rowData[] = self::convertStringToPHPType($row[$columnName], $columnDesc['data_type']);
                }
            }
            $callbackProcessor($rowData, $callbackContext);
        }
    }
    
    /**
     * Convert the SQL string value to a native PHP value.
     * @param string $value The SQL value to convert
     * @param string $sqlDataType The SQL data type ('int', 'decimal', ...).
     * @return mixed The SQL string value converted to integer or float value if
     * necessary.
     */
    static protected function convertStringToPHPType($value, $sqlDataType) {
        switch ($sqlDataType) {
            case 'int':
            case 'bigint':
            case 'tinyint':
            case 'smallint': 
            case 'mediumint':
                return intval($value);
            case 'decimal':
            case 'float':
            case 'double':
                return floatval($value);
            default:
                return $value;
        }
    }
    
}
