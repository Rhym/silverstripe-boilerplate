<?php

/**
 * Class PortfolioPageModelAdmin
 */
class PortfolioPageModelAdmin extends CatalogPageAdmin
{

    private static $menu_icon = 'boilerplate/code/Modules/Portfolio/images/briefcase.png';

    private static $managed_models = array(
        'PortfolioPage'
    );

    //private static $menu_priority = 1;

    private static $url_segment = 'portfolio';

    private static $menu_title = 'Portfolio';

    private static $url_handlers = array(
        '$ModelClass/$Action' => 'handleAction',
        '$ModelClass/$Action/$ID' => 'handleAction',
    );

    public function getEditForm($id = null, $fields = null)
    {
        /** =========================================
         * @var Form $form
         * @var GridField $gridField
        ===========================================*/

        $form = parent::getEditForm($id, $fields);
        if ($this->modelClass == 'PortfolioPage' && $gridField = $form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
            /**
             * This is just a precaution to ensure we got a GridField from dataFieldByName() which you should have
             */
            if ($gridField instanceof GridField) {
                $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'));
            }
        }

        return $form;
    }

}