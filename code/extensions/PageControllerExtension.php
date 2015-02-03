<?php

/**
 * Class PageControllerExtension
 */
class PageControllerExtension extends Extension {

	public function onBeforeInit() {

        /* =========================================
         * Combine JS
         =========================================*/

        Requirements::combine_files(
            'combined.js',
            array(
                JS_LIB_DIR.'/jquery.1.11.1.min.js',
                JS_LIB_DIR.'/modernizr.2.8.3.js',
                JS_LIB_DIR.'/bootstrap-3.3.1.js',
                JS_LIB_DIR.'/waypoints-2.0.5.min.js',
                BOILERPLATE_MODULE.'/code/Modules/PopoutMenu/javascript/popout-menu.js',
                JS_DIR.'/script.js'
            )
        );

        /* =========================================
         * CSS
         =========================================*/

        Requirements::css(CSS_DIR.'/main.min.css');
        //Requirements::css('themes/boilerplate/css/main.min.css');

        /* =========================================
         * IE Shivs
         =========================================*/

        $baseHref = Director::BaseURL();

        Requirements::insertHeadTags('<!--[if lt IE 9]>
            <script type="text/javascript" src="'.$baseHref.JS_LIB_DIR.'/html5.js"></script>
            <script type="text/javascript" src="'.$baseHref.JS_LIB_DIR.'/respond.min.js"></script>
        <![endif]-->');

    }

    // TODO Implement somewhere.
    /**
     * @return array
     * Change the page template depending on the "DisplayType" row.
     */
//    public function index(){
//        if($this->DisplayType == 'Grid'){
//            $class = $this->ClassName . "_Controller";
//            $controller = new $class($this);
//            return $controller->renderWith(array('MenuHolder_Grid', 'Page'));
//        }
//        return array();
//    }

}