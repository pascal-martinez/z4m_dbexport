<?php
/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://mobile.znetdk.fr
 * Copyright (C) 2025 Pascal MARTINEZ (contact@znetdk.fr)
 * License GNU GPL https://www.gnu.org/licenses/gpl-3.0.html GNU GPL
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
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 * --------------------------------------------------------------------
 * Parameters of the ZnetDK 4 Mobile DB Export module
 *
 * File version: 1.0
 * Last update: 04/12/2025
 */


/**
 * SQL tables excluded from the DB export
 * @var array|NULL Table names. For example: ['my_table1', 'my_table2'].
 * If NULL, all SQL tables are exported
 */
define('MOD_Z4M_DBEXPORT_EXCLUDED_TABLES', NULL);

/**
 * SQL tables selected for the DB export
 * @var array|NULL Table names. For example: ['my_table1', 'my_table2'].
 * If NULL, all SQL tables are exported
 */
define('MOD_Z4M_DBEXPORT_SELECTED_TABLES', NULL);


/**
 * Data type conversion between MySQL and Excel
 * @var array Conversion table.
 */
define('MOD_Z4M_DBEXPORT_MYSQLTOEXCEL_DATA_TYPES', ['int' => 'integer',
    'bigint' => 'integer', 'tinyint' => 'integer', 'smallint' => 'integer',
    'mediumint' => 'integer', 'date' => 'date', 'datetime' => 'datetime',
    'time' => 'time', 'decimal' => '0.00', 'float' => '0.00000',
    'double' => '0.00000']);


/**
 * Color scheme applied to the DB Export view.
 * @var array|NULL Colors used to display the DB Export view. The expected array
 * keys is 'btn_action'.
 * If NULL, default color CSS classes are applied.
 */
define('MOD_Z4M_DBEXPORT_COLOR_SCHEME', NULL);

/**
 * Module version number
 * @return string Version
 */
define('MOD_Z4M_DBEXPORT_VERSION_NUMBER','1.0');
/**
 * Module version date
 * @return string Date in W3C format
 */
define('MOD_Z4M_DBEXPORT_VERSION_DATE','2025-04-12');