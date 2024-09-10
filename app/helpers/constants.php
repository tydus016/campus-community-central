<?php

defined('NOT_DELETED') or define('NOT_DELETED', 0);
defined('IS_DELETED') or define('IS_DELETED', 1);

define('PW_HASHED', '********');

defined('ADMIN_TYPE_SUPER') or define('ADMIN_TYPE_SUPER', 1);
defined('ADMIN_TYPE_ADMIN') or define('ADMIN_TYPE_ADMIN', 2);
defined('ADMIN_TYPE_STAFF') or define('ADMIN_TYPE_STAFF', 3);

defined('ACCOUNT_STATUS_INACTIVE') or define('ACCOUNT_STATUS_INACTIVE', 0);
defined('ACCOUNT_STATUS_ACTIVE') or define('ACCOUNT_STATUS_ACTIVE', 1);

defined('DEFAULT_PROFILE_IMAGE') or define('DEFAULT_PROFILE_IMAGE', "assets/static/images/icon/profile-template.png");
defined('DEFAULT_VEHICLE_IMAGE') or define('DEFAULT_VEHICLE_IMAGE', "assets/static/images/icon/car-icon.png");

defined('GEOFENCE_DEFAULT_DESCRIPTION') or define('GEOFENCE_DEFAULT_DESCRIPTION', "this is a geofence zone");
defined('GEOFENCE_STATUS_INACTIVE') or define('GEOFENCE_STATUS_INACTIVE', 0);
defined('GEOFENCE_STATUS_ACTIVE') or define('GEOFENCE_STATUS_ACTIVE', 1);
