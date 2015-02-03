<?php

/**
 * Class ColumnsPageExtension
 */
class ColumnsPageExtension extends DataExtension {

    private static $db = array(
        'Columns' => 'Int'
    );

    /**
     * @param FieldList $fields
     * @return FieldList
     */
    public function updateCMSFields(FieldList $fields) {

        $fields->addFieldToTab('Root.Gallery', new HeaderField('Settings'));
        $fields->addFieldToTab('Root.Gallery', $columns = new OptionsetField('Columns', _t('GalleryPage.ColumnsLabel', 'Columns (items)'), array(
            'One (Full Width)',
            'Two',
            'Three',
            'Four',
            'Six',
            'Twelve'
        )));
        $columns->setRightTitle('How many items to display on each row');

        return $fields;

    }

    private static $defaults = array(
        'Columns' => 2
    );

}

/**
 * Class ColumnsPageControllerExtension
 */
class ColumnsPageControllerExtension extends Extension {

    /**
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