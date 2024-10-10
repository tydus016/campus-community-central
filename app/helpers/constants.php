<?php

defined('NOT_DELETED') or define('NOT_DELETED', 0);
defined('IS_DELETED') or define('IS_DELETED', 1);

define('PW_HASHED', '********');

defined('ACCOUNT_TYPE_USER') or define('ACCOUNT_TYPE_USER', 1);
defined('ACCOUNT_TYPE_ADMIN') or define('ACCOUNT_TYPE_ADMIN', 2);
defined('ACCOUNT_TYPE_HEAD_ADMIN') or define('ACCOUNT_TYPE_HEAD_ADMIN', 3);

defined('ACCOUNT_STATUS_INACTIVE') or define('ACCOUNT_STATUS_INACTIVE', 0);
defined('ACCOUNT_STATUS_ACTIVE') or define('ACCOUNT_STATUS_ACTIVE', 1);

defined('DEFAULT_PROFILE_IMAGE') or define('DEFAULT_PROFILE_IMAGE', "assets/static/images/icon/profile-template.png");
defined('DEFAULT_VEHICLE_IMAGE') or define('DEFAULT_VEHICLE_IMAGE', "assets/static/images/icon/car-icon.png");

defined('GEOFENCE_DEFAULT_DESCRIPTION') or define('GEOFENCE_DEFAULT_DESCRIPTION', "this is a geofence zone");
defined('GEOFENCE_STATUS_INACTIVE') or define('GEOFENCE_STATUS_INACTIVE', 0);
defined('GEOFENCE_STATUS_ACTIVE') or define('GEOFENCE_STATUS_ACTIVE', 1);

defined('AVAILABLE_FLG') or define('AVAILABLE_FLG', 1);
defined('UNAVAILABLE_FLG') or define('UNAVAILABLE_FLG', 0);

// - order status
defined('ORDER_STATUS_ONGOING') or define('ORDER_STATUS_ONGOING', 0);
defined('ORDER_STATUS_COMPLETED') or define('ORDER_STATUS_COMPLETED', 1);
defined('ORDER_STATUS_VOIDED') or define('ORDER_STATUS_VOIDED', 2);

// - payment method
defined('PAYMENT_METHOD_CASH') or define('PAYMENT_METHOD_CASH', 1);
defined('PAYMENT_METHOD_CARD') or define('PAYMENT_METHOD_CARD', 2);
defined('PAYMENT_METHOD_EWALLET') or define('PAYMENT_METHOD_EWALLET', 3);

// - on sale flag
defined('ON_SALE_FLG') or define('ON_SALE_FLG', 1);
defined('NOT_ON_SALE_FLG') or define('NOT_ON_SALE_FLG', 0);

// - summary static
defined('DUMMY_DISCOUNT') or define('DUMMY_DISCOUNT', 0.00);
defined('DUMMY_TAX') or define('DUMMY_TAX', 1.55);

// - stock status
defined('STOCK_STATUS_IN_STOCK') or define('STOCK_STATUS_IN_STOCK', 1);
defined('STOCK_STATUS_OUT_OF_STOCK') or define('STOCK_STATUS_OUT_OF_STOCK', 0);
