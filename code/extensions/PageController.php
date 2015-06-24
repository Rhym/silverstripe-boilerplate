<?php

/**
 * Class PageControllerExtension
 */
class PageControllerExtension extends Extension {

	public function onBeforeInit() {

        $baseHref = Director::BaseURL();

        /** -----------------------------------------
         * Javascript
        -------------------------------------------*/

        Requirements::insertHeadTags('<script type="text/javascript" src="'.$baseHref.project().'/javascript/lib/modernizr.min.js"></script>');

        /**
         * Set All JS to be right before the closing </body> tag.
         */
        Requirements::set_force_js_to_bottom(true);
        if (Director::isDev()) {
            Requirements::javascript(project().'/javascript/main.js');
        } else {
            Requirements::javascript(project().'/javascript/main.min.js');
        }

        /** -----------------------------------------
         * CSS
        -------------------------------------------*/

        Requirements::css(project().'/css/font-awesome.min.css');
        if (Director::isDev()) {
            Requirements::css(project().'/css/main.css');
        } else {
            Requirements::css(project().'/css/main.min.css');
        }

        /** -----------------------------------------
         * Shivs
        -------------------------------------------*/

        Requirements::insertHeadTags('<!--[if lt IE 9]>
            <script type="text/javascript" src="'.$baseHref.project().'/javascript/lib/html5shiv.min.js"></script>
            <script type="text/javascript" src="'.$baseHref.project().'/javascript/lib/respond.min.js"></script>
        <![endif]-->');

    }

    /**
     * @todo Implement somewhere.
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