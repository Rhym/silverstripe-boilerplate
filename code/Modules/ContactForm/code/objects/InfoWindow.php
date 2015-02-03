<?php

/**
 * Class InfoWindow
 */
class InfoWindow extends DataObject{

    private static $menu_icon = '';

    private static $singular_name = 'Marker';

    private static $db = array (
        'Title' => 'Varchar(255)',
        'Lat' => 'Varchar(255)',
        'Long' => 'Varchar(255)'
    );

    private static $has_one = array(
        'ContactPage' => 'ContactPage'
    );

    private static $summary_fields = array(
        'Title' => 'Title'
    );

    private static $default_sort = 'Title ASC';

    /**
     * @return FieldList
     */
    public function getCMSFields() {
        $fields = FieldList::create(TabSet::create('Root'));

        $fields->addFieldToTab('Root.Main', new TextField('Title', 'Title'));
        $fields->addFieldToTab('Root.Main', new TextField('Lat', 'Latitude'));
        $fields->addFieldToTab('Root.Main', new TextField('Long', 'Longitude'));

        return $fields;
    }

}