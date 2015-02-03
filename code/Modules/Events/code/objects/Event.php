<?php

/**
 * Class Event
 */
class Event extends DataObject{

    private static $db = array (
        'Title' => 'Text',
        'Date' => 'Date',
        'TimeStart' => 'Time',
        'TimeEnd' => 'Time',
        'Content' => 'HTMLText',
        'SortOrder' => 'Int'
    );

    private static $has_one = array (
        'SiteConfig' => 'SiteConfig'
    );

    private static $summary_fields = array(
        'Date.Nice' => 'Date',
        'Title' => 'Title'
    );

    private static $default_sort = 'Date DESC';

    /**
     * @return FieldList
     */
    public function getCMSFields() {
        $fields = FieldList::create(TabSet::create('Root'));

        $fields->addFieldToTab('Root.Main', new TextField('Title'));
        $fields->addFieldToTab('Root.Main', new HeaderField('', 'Details', 4));
        $fields->addFieldToTab('Root.Main', $dateField = new DateField('Date'));
        $dateField->setConfig('showcalendar', true);
        $fields->addFieldToTab('Root.Main', $timeStart = new TimeField('TimeStart', 'Start'));
        $timeStart->setRightTitle('e.g 12pm');
        $fields->addFieldToTab('Root.Main', $timeEnd = new TimeField('TimeEnd', 'End (optional)'));
        $timeEnd->setRightTitle('e.g 3:30 pm');
        $fields->addFieldToTab('Root.Main', $content = new HtmlEditorField('Content'));
        $content->setRows(15);

        return $fields;
    }

    /**
     * @return bool|string
     */
    public function getLink(){
        /**
         * Check if there currently is an EventsPage in the sitetree, and the "events" method is in the controller extension.
         */
        if(EventsPage::get()->exists() && method_exists(new EventsPage_Controller, 'event')){
            return EventsPage::get()->first()->Link().'event/'.$this->ID;
        }
        return false;
    }

}