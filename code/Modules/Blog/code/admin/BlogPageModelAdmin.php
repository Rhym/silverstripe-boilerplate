<?php

/**
 * Class BlogPageModelAdmin
 */
class BlogPageModelAdmin extends CatalogPageAdmin
{
    /**
     * @var string
     */
    private static $menu_icon = 'boilerplate/code/Modules/Blog/images/pencil.png';

    /**
     * @var string
     */
    private static $menu_icon_class = 'fa fa-pencil';

    /**
     * @var array
     */
    private static $managed_models = array(
        'BlogPage'
    );

    /**
     * @var string
     */
    private static $url_segment = 'blog';

    /**
     * @var string
     */
    private static $menu_title = 'Blog';

    /**
     * @var array
     */
    private static $url_handlers = array(
        '$ModelClass/$Action' => 'handleAction',
        '$ModelClass/$Action/$ID' => 'handleAction',
    );

    public function getEditForm($id = null, $fields = null)
    {
        /** @var Form $form */
        $form = parent::getEditForm($id, $fields);
        if ($this->modelClass == 'BlogPage' && $gridField = $form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
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
