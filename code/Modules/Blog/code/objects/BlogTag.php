<?php

/**
 * Class BlogTag
 */
class BlogTag extends DataObject{

    static $db = array (
        'Title' => 'Varchar(255)'
    );

    private static $singular_name = 'Tag';
    private static $plural_name = 'Tags';

    private static $belongs_many_many = array(
        'Page' => 'Page'
    );

    public function getCMSValidator() {
        return new RequiredFields(array(
            'Title'
        ));
    }

    public static $summary_fields = array(
  		'Title' => 'Title'
 	);

    /**
     * @return FieldList
     */
    public function getCMSFields() {
        $fields = FieldList::create(TabSet::create('Root'));
        $fields->addFieldToTab('Root.Main', new TextField('Title'));
        return $fields;
    }

}