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
 * ZnetDK 4 Mobile DB export module view
 * 
 * File version: 1.0
 * Last update: 04/12/2025
 */
$color = [
    'btn_action' => 'w3-theme-action'
];
if (is_array(MOD_Z4M_DBEXPORT_COLOR_SCHEME)) {
    $color = MOD_Z4M_DBEXPORT_COLOR_SCHEME;
} elseif (defined('CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME')) {
    $color = CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME;
}
?>
<div class="w3-content">
    <p><?php echo MOD_Z4M_DBEXPORT_DOWNLOAD_INTRO_TEXT; ?></p>
    <button id="z4m-db-export-download-btn" class="w3-button <?php echo $color['btn_action']; ?>" type="button"
            onclick="znetdkMobile.file.display('<?php echo General::getURIforDownload('Z4MDBExportCtrl'); ?>');">
        <i class="fa fa-download"></i> <?php echo MOD_Z4M_DBEXPORT_DOWNLOAD_BUTTON_LABEL; ?>
    </button>
</div>