<?php

/**
 * Class BlogTag
 */
class BlogTag extends DataObject{

    static $db = array (
        'Title' => 'Varchar(255)'
    );

    private static $belongs_many_many = array(
        'Page' => 'Page'
    );

    public static $summary_fields = array(
  		'Title' => 'Title'
 	);

    /**
     * @return FieldList
     */
    public function getCMSFields() {
        $fields = FieldList::create(TabSet::create('Root'));

        $fields->addFieldToTab('Root.Main', new TextField('Title', 'Tag Title'));

        return $fields;
    }

}