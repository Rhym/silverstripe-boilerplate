<?php

/**
 * Class ContactMessageModelAdmin
 */
class ContactMessageModelAdmin extends ModelAdmin
{
    /**
     * @var string
     */
    private static $menu_icon = 'boilerplate/code/Modules/ContactForm/images/message-menu.png';

    /**
     * @var string
     */
    private static $menu_icon_class = 'fa fa-comments-o';

    /**
     * @var array
     */
    private static $managed_models = array(
        'ContactMessage'
    );

    /**
     * @var int
     */
    private static $url_priority = 100;

    /**
     * @var string
     */
    private static $url_segment = 'messages';

    /**
     * @var string
     */
    private static $menu_title = 'Messages';

    /**
     * @var array
     */
    private static $url_handlers = array(
        '$ModelClass/$Action' => 'handleAction',
        '$ModelClass/$Action/$ID' => 'handleAction',
    );

    /**
     * @param null $id
     * @param null $fields
     * @return mixed
     */
    public function getEditForm($id = null, $fields = null)
    {
        /** @var Form $form */
        $form = parent::getEditForm($id, $fields);

        $gridFieldName = $this->sanitiseClassName($this->modelClass);
        /** @var GridField $gridField */
        $gridField = $form->Fields()->fieldByName($gridFieldName);
        $gridField->getConfig()->removeComponentsByType($gridField->getConfig()->getComponentByType('GridFieldAddNewButton'));
        $gridField->getConfig()->removeComponentsByType($gridField->getConfig()->getComponentByType('GridFieldPrintButton'));

        return $form;
    }

    /**
     * Fields displayed in a CSV export
     *
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'FirstName' => 'First Name',
            'LastName' => 'Last Name',
            'Email' => 'Email',
            'Phone' => 'Phone',
            'Message' => 'Message'
        );
    }

}
