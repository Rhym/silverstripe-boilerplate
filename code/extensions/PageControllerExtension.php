<?php

/**
 * Class PageControllerExtension
 */
class PageControllerExtension extends Extension {

	public function onBeforeInit() {

        /** =========================================
         * Combine JS
         ==========================================*/

        /**
         * Set All JS to be right before the closing </body> tag.
         */
        Requirements::set_force_js_to_bottom(true);

        Requirements::combine_files(
            'combined.js',
            array(
                BOWER_COMPONENTS_DIR.'/jquery/dist/jquery.min.js',
                BOWER_COMPONENTS_DIR.'/modernizr/modernizr.js',
                BOWER_COMPONENTS_DIR.'/owl.carousel/dist/owl.carousel.min.js',
                BOWER_COMPONENTS_DIR.'/bootstrap-sass/assets/javascripts/bootstrap/modal.js',
                BOWER_COMPONENTS_DIR.'/bootstrap-sass/assets/javascripts/bootstrap/collapse.js',
                BOILERPLATE_MODULE.'/code/Modules/PopoutMenu/javascript/popout-menu.js',
                project().'/javascript/build/script.min.js'
            )
        );

        /** =========================================
         * CSS
         ==========================================*/

        Requirements::css(BOWER_COMPONENTS_DIR.'/components-font-awesome/css/font-awesome.min.css');
        Requirements::combine_files(
            'combined.min.css',
            array(
                /**
                 * Owl Carousel
                 */
                BOWER_COMPONENTS_DIR.'/owl.carousel/dist/assets/owl.carousel.min.css',
                /**
                 * Application styles
                 */
                project().'/css/main.min.css'
            )
        );

        /** =========================================
         * Ancient Browser Shivs
         ==========================================*/

        $baseHref = Director::BaseURL();
        Requirements::insertHeadTags('<!--[if lt IE 9]>
            <script type="text/javascript" src="'.$baseHref.BOWER_COMPONENTS_DIR.'/html5shiv/dist/html5shiv.min.js"></script>
            <script type="text/javascript" src="'.$baseHref.BOWER_COMPONENTS_DIR.'/respond/dest/respond.min.js"></script>
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