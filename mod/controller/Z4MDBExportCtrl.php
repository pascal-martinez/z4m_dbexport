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
 * ZnetDK 4 Mobile DB Export module Controller class
 *
 * File version: 1.0
 * Last update: 04/12/2025
 */

namespace z4m_dbexport\mod\controller;

use \z4m_dbexport\mod\DBExport;

/**
 * App controller to download the data stored in database for the App
 *
 */
class Z4MDBExportCtrl extends \AppController {

    /**
     * Evaluates whether action is allowed or not.
     * When authentication is required, action is allowed if connected user has
     * full menu access or if has a profile allowing access to the
     * 'z4m_dbexport' view.
     * If no authentication is required, action is allowed if the expected view
     * menu item is declared in the 'menu.php' script of the application.
     * @param string $action Action name
     * @return Boolean TRUE if action is allowed, FALSE otherwise
     */
    static public function isActionAllowed($action) {
        $status = parent::isActionAllowed($action);
        if ($status === FALSE) {
            return FALSE;
        }
        $actionView = [
            'download' => 'z4m_dbexport'
        ];
        $menuItem = key_exists($action, $actionView) ? $actionView[$action] : NULL;
        return CFG_AUTHENT_REQUIRED === TRUE
            ? \controller\Users::hasMenuItem($menuItem) // User has right on menu item
            : \MenuManager::getMenuItem($menuItem) !== NULL; // Menu item declared in 'menu.php'
    }


    /**
     * Controller action called for downloading the DB data.
     * @return \Response file in Excel format.
     */
    static protected function action_download() {
        $response = new \Response();
        try {
            $filepath = self::getExcelDataFilePath();
        } catch (\Exception $ex) {
            \General::writeErrorLog(__METHOD__, $ex->getMessage());
            $response->doHttpError(500, 'Excel export', "An error occured while exporting data.");
        }
        $response->setFileToDownload($filepath, FALSE);
        return $response;
    }

    /**
     * Generates the DB data file in Excel format.
     * @return string The file path of the generated Excel file 
     * @throws \Exception The storage folder set in CFG_DOCUMENTS_DIR PHP
     *  constant is missing.
     */
    static protected function getExcelDataFilePath() {
        $exportDate = (new \DateTime('now'))->format('Ymd_His');
        $filename = "appdata_{$exportDate}.xlsx";
        $documentPath = CFG_DOCUMENTS_DIR . DIRECTORY_SEPARATOR;
        if (!is_dir($documentPath)) {
            throw new \Exception("Storage directory '{$documentPath}' does not exist.");
        }
        $filePath = $documentPath . $filename;
        DBExport::generateExcelFile($filePath);
        return $filePath;
    }
}
