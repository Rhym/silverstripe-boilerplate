<?php

/**
 * Class BlogPageModelAdmin
 */
class BlogPageModelAdmin extends CatalogPageAdmin {

    private static $menu_icon = 'boilerplate/code/Modules/Blog/images/pencil.png';

    private static $managed_models = array(
        'BlogPage'
    );

    //private static $menu_priority = 1;

    private static $url_segment = 'blog';

    private static $menu_title = 'Blog';

    private static $url_handlers = array(
        '$ModelClass/$Action' => 'handleAction',
        '$ModelClass/$Action/$ID' => 'handleAction',
    );

    public function getEditForm($id = null, $fields = null) {
        /** =========================================
         * @var Form        $form
         * @var GridField   $gridField
        ===========================================*/

        $form = parent::getEditForm($id, $fields);
        if($this->modelClass == 'BlogPage' && $gridField = $form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
            /**
             * This is just a precaution to ensure we got a GridField from dataFieldByName() which you should have
             */
            if($gridField instanceof GridField) {
                $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'));
            }
        }

        return $form;
    }

}