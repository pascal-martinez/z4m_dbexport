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

require 'PHP_XLSXWriter' . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . 'xlsxwriter.class.php';

/**
 * Generates an Excel file from the PHP_XLSXWriter class (see project on github
 * at https://github.com/mk-j/PHP_XLSXWriter/tree/master  ).
 */
class ExcelGenerator extends \XLSXWriter {
    protected $filePath;
    protected $sheetName;
    protected $header;
    
    /**
     * Class constructor
     * @param string $filePath File path of the Excel file to generate
     * @param string $company Company's name
     * @param string $title Document's title
     * @param string $subject Document's subject
     * @param string $description Description of the document
     */
    public function __construct($filePath, $company = '', $title = '', $subject = '', $description = '') {
        $this->filePath = $filePath;
        $this->setAuthor(strval(\UserSession::getUserName()));
        $this->setCompany(strval($company));
        $this->setTitle(strval($title));
        $this->setSubject(strval($subject));
        $this->setDescription(strval($description));
        parent::__construct();
    }
    
    /**
     * Sets the name of the current sheet to fill in
     * @param string $sheetName Sheet name
     */
    public function setSheetName($sheetName) {
        $this->sheetName = $sheetName;
    }
    
    /**
     * Set the table header columns for the current sheet.
     * @param array $header An array of columns. 
     * For example: ['Col 1' => 'string', 'Col 2' => 'date'].
     */
    public function setSheetHeader($header) {
        $this->header = $header;
        $this->writeSheetHeader($this->sheetName, $header, ['font-style' => 'bold']);
        
    }
    
    /**
     * Adds a row to the table within the current sheet
     * @param array $row An array of values.
     */
    public function addRowToSheet($row) {
        parent::writeSheetRow($this->sheetName, $row);
    }
    
    /**
     * Writes sheet data to the Excel file.
     */
    public function write() {
        $this->writeToFile($this->filePath);
    }
    
}
