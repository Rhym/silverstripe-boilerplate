<?php

define('BOILERPLATE_MODULE', 'boilerplate');

/** -----------------------------------------
 * CSS
-------------------------------------------*/

define('CSS_DIR', BOILERPLATE_MODULE.'/css');

/** -----------------------------------------
 * Javascript
-------------------------------------------*/

define('JS_DIR', BOILERPLATE_MODULE.'/javascript');
define('JS_LIB_DIR', JS_DIR.'/lib');
define('BOWER_COMPONENTS_DIR', 'components/lib');

/** -----------------------------------------
 * Modules
-------------------------------------------*/

define('MODULE_DIR', BOILERPLATE_MODULE.'/code/Modules');

define('BLOG_MODULE_DIR', MODULE_DIR.'/Blog');
define('CONTACT_FORM_MODULE_DIR', MODULE_DIR.'/ContactForm');
define('FLASH_MESSAGE_MODULE_DIR', MODULE_DIR.'/FlashMessage');
define('GALLERY_MODULE_DIR', MODULE_DIR.'/Gallery');
define('POPOUT_MENU_MODULE_DIR', MODULE_DIR.'/PopoutMenu');
define('PORTFOLIO_MODULE_DIR', MODULE_DIR.'/Portfolio');
define('REGISTRATION_MODULE_DIR', MODULE_DIR.'/Registration');
define('SHORTCODES_MODULE_DIR', MODULE_DIR.'/Shortcodes');
define('SLIDER_MODULE_DIR', MODULE_DIR.'/Slider');

/**
 * Check if the module folder exists.
 */
if (basename(dirname(__FILE__)) != BOILERPLATE_MODULE) {
    throw new Exception(BOILERPLATE_MODULE . ' module not installed in correct directory');
}