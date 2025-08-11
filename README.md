# ZnetDK 4 Mobile module: DB Export (z4m_dbexport)

The **z4m_dbexport** module exports the SQL table data of the [ZnetDK 4 Mobile](/../../../znetdk4mobile) starter application in Excel format in one click.

> [!NOTE]
> This module embeds and uses [PHP_XLSXWriter](https://github.com/mk-j/PHP_XLSXWriter) to generate the Excel file.

## LICENCE
This module is published under the [version 3 of GPL General Public Licence](LICENSE.TXT).

## FEATURES
This module contains the `z4m_dbexport` view to declare within the [`menu.php`](/../../../znetdk4mobile/blob/master/applications/default/app/menu.php)
of the application.  
This view is very simple and just shows a download button to get App's data in Excel format.  
Each sheet of the downloaded spreadsheet contains data of one SQL table.

## REQUIREMENTS
- [ZnetDK 4 Mobile](/../../../znetdk4mobile) version 2.9 or higher,
- A **MySQL** database [is configured](https://mobile.znetdk.fr/getting-started#z4m-gs-connect-config) to store the application data,
- **PHP version 7.4** or higher,
- Authentication is enabled
([`CFG_AUTHENT_REQUIRED`](https://mobile.znetdk.fr/settings#z4m-settings-auth-required)
is `TRUE` in the App's
[`config.php`](/../../../znetdk4mobile/blob/master/applications/default/app/config.php)).

## INSTALLATION
1. Add a new subdirectory named `z4m_dbexport` within the
[`./engine/modules/`](/../../../znetdk4mobile/tree/master/engine/modules/) subdirectory of your
ZnetDK 4 Mobile starter App,
2. Copy module's code in the new `./engine/modules/z4m_dbexport/` subdirectory,
or from your IDE, pull the code from this module's GitHub repository,
3. Edit the App's [`menu.php`](/../../../znetdk4mobile/blob/master/applications/default/app/menu.php)
located in the [`./applications/default/app/`](/../../../znetdk4mobile/tree/master/applications/default/app/)
subfolder and add a new menu item definition for the view `z4m_dbexport`.
For example:  
```php
\MenuManager::addMenuItem(NULL, 'z4m_dbexport', MOD_Z4M_DBEXPORT_MENU_LABEL, 'fa-cloud-download');
```
4. Edit the App's [`config.php`](/../../../znetdk4mobile/blob/master/applications/default/app/config.php)
located in the [`./applications/default/app/`](/../../../znetdk4mobile/tree/master/applications/default/app/)
subfolder and declare the `MOD_Z4M_DBEXPORT_SELECTED_TABLES` or `MOD_Z4M_DBEXPORT_EXCLUDED_TABLES` PHP constant 
to set SQL tables to include in or to exclude from the export file. For example:
```php
// Only the two tables below will be exported:
define('MOD_Z4M_DBEXPORT_SELECTED_TABLES', ['my_table_one', 'my_table_two']);

// All the tables will be exported except the two tables below:
define('MOD_Z4M_DBEXPORT_EXCLUDED_TABLES', ['zdk_users', 'zdk_profiles']);
```
5. Go to the **Data export** menu and click the **Download...** button to get App's SQL table data in a Excel spreadsheet file. 

## USERS GRANTED TO MODULE FEATURES
Once the **Data export** menu item is added to the application, you can restrict 
its access via a [user profile](https://mobile.znetdk.fr/settings#z4m-settings-user-rights).  
For example:
1. Create a user profile named `Admin` from the **Authorizations | Profiles** menu,
2. Select for this new profile, the **Data export** menu item,
3. Finally for each allowed user, add them the `Admin` profile from the
**Authorizations | Users** menu. 

## TRANSLATIONS
This module is translated in **French**, **English** and **Spanish** languages.  
To translate this module in another language or change the standard
translations:
1. Copy in the clipboard the PHP constants declared within the 
[`locale_en.php`](mod/lang/locale_en.php) script of the module,
2. Paste them from the clipboard within the
[`locale.php`](/../../../znetdk4mobile/blob/master/applications/default/app/lang/locale.php) script of your application,   
3. Finally, translate each text associated with these PHP constants into your own language.

## CHANGE LOG
See [CHANGELOG.md](CHANGELOG.md) file.

## CONTRIBUTING
Your contribution to the **ZnetDK 4 Mobile** project is welcome. Please refer to the [CONTRIBUTING.md](https://github.com/pascal-martinez/znetdk4mobile/blob/master/CONTRIBUTING.md) file.
