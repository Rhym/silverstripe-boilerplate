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
                // jQuery
                BOWER_COMPONENTS_DIR.'/jquery/dist/jquery.min.js',
                // Modernizr
                BOWER_COMPONENTS_DIR.'/modernizr/modernizr.js',
                // Owl Carousel
                BOWER_COMPONENTS_DIR.'/owlcar/owl-carousel/owl.carousel.min.js',
                // Boostrap
                BOWER_COMPONENTS_DIR.'/bootstrap-sass/assets/javascripts/bootstrap/modal.js',
                // Pop-out menu module
                BOILERPLATE_MODULE.'/code/Modules/PopoutMenu/javascript/popout-menu.js',
                // Application scripts
                JS_DIR.'/script.js'
            )
        );

        /* =========================================
         * CSS
         =========================================*/

        Requirements::combine_files(
            'combined.min.css',
            array(
                // Owl Carousel
                BOWER_COMPONENTS_DIR.'/owlcar/owl-carousel/owl.carousel.css',
                BOWER_COMPONENTS_DIR.'/owlcar/owl-carousel/owl.theme.css',
                BOWER_COMPONENTS_DIR.'/owlcar/owl-carousel/owl.transition.css',
                // Boilerplate styles
                CSS_DIR.'/main.min.css',
                // Application styles
                project().'/css/main.min.css'
            )
        );

        /* =========================================
         * Ancient Browser Shivs
         =========================================*/

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