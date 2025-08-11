# CHANGE LOG: DB Export (z4m_dbexport)

## Version 1.1, 2025-08-08
BUG FIXING: in the `README.md` file, documentation was incorrect in the example below:
define('MOD_Z4M_DBEXPORT_SELECTED_TABLES', ['zdk_users', 'zdk_profiles']);
Is replaced by:
define('MOD_Z4M_DBEXPORT_EXCLUDED_TABLES', ['zdk_users', 'zdk_profiles']);

## Version 1.0, 2025-04-12
First version.