<?php

/**
 * Class ColumnsPageExtension
 */
class ColumnsPageExtension extends DataExtension {

    private static $db = array(
        'Columns' => 'Int',
        'Items' => 'Int'
    );

    private static $defaults = array(
        'Columns' => 1,
        'Items' => 10
    );

    /**
     * @param FieldList $fields
     * @return FieldList
     */
    public function updateCMSFields(FieldList $fields) {

        $fields->addFieldToTab('Root.Main', new HeaderField('', 'Display', 4), 'Content');
        $fields->addFieldToTab('Root.Main', $columns = new OptionsetField('Columns', 'Columns (items)', array(
            'One (Full Width)',
            'Two',
            'Three',
            'Four',
            'Six'
        )), 'Content');
        $columns->setRightTitle('How many items to display on each row i.e "Two" will be displayed as two items taking up half the content space and displayed beside each other.');
        $fields->addFieldToTab('Root.Main', $items = new NumericField('Items', 'Items'), 'Content');
        $items->setRightTitle('Items outside of this limit will be displayed in a paginated list i.e "Page 1 - 2 - 3."');

        return $fields;
    }

}

/**
 * Class ColumnsPageControllerExtension
 */
class ColumnsPageControllerExtension extends Extension {

    /**
     * Return column classes - based on boostrap classes.
     *
     * @return string
     */
    public function ColumnClass(){
        switch($this->owner->Columns){
            case 1:
                return 'col-sm-6';
                break;
            case 2:
                return 'col-sm-4';
                break;
            case 3:
                return 'col-sm-3';
                break;
            case 4:
                return 'col-sm-2';
                break;
            case 5:
                return 'col-sm-1';
                break;
            default:
                return 'col-sm-12';
        }
    }

    /**
     * Return columns - based on boostrap columns.
     *
     * @return int
     */
    public function ColumnMultiple(){
        switch($this->owner->Columns){
            case 1:
                return 2;
                break;
            case 2:
                return 3;
                break;
            case 3:
                return 4;
                break;
            case 4:
                return 6;
                break;
            case 5:
                return 12;
                break;
            default:
                return 1;
        }
    }

}