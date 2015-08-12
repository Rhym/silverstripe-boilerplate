<?php

/**
 * Class ContactMessage
 *
 * @property string FirstName
 * @property string LastName
 * @property string Email
 * @property string Phone
 * @property string Message
 */
class ContactMessage extends DataObject
{

    /**
     * @var array
     */
    private static $db = array(
        'FirstName' => 'Varchar(255)',
        'LastName' => 'Varchar(255)',
        'Email' => 'Varchar(255)',
        'Phone' => 'Varchar(255)',
        'Message' => 'Text'
    );

    /**
     * @var array
     */
    private static $summary_fields = array(
        'Created.Nice' => 'Received',
        'FirstName' => 'First Name',
        'LastName' => 'Last Name',
        'Phone' => 'Phone Number',
        'Email' => 'Email'
    );

    private static $default_sort = 'Created DESC';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        /** =========================================
         * @var FieldList $fields
        ===========================================*/

        $fields = FieldList::create(TabSet::create('Root'));

        $fields->addFieldToTab('Root.Main', ReadonlyField::create('FirstName'));
        $fields->addFieldToTab('Root.Main', ReadonlyField::create('LastName'));
        $fields->addFieldToTab('Root.Main', LiteralField::create('',
            '<div class="field"><label class="left">Email</label><div class="middlecolumn"><span class="readonly"><a href="mailto:' . $this->Email . '">' . $this->Email . '</a></span></div></div>'));
        $fields->addFieldToTab('Root.Main', ReadonlyField::create('Phone'));
        $fields->addFieldToTab('Root.Main', ReadonlyField::create('Message'));

        return $fields;
    }

}
