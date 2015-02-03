<?php

/**
 * Class GalleryPage
 */
class GalleryPage extends Page {

    private static $icon = 'boilerplate/code/Modules/Gallery/images/folder-open-image.png';

    private static $db = array(
        'Items' => 'Int',
        'NoMargin' => 'Boolean(0)'
    );

    public static $many_many = array(
        'Images' => 'Image'
    );

    private static $defaults = array(
        'Items' => 10
    );

    private static $description = 'Displays a lightbox gallery of images';

    /**
     * @return FieldList
     */
    public function getCMSFields() {

        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Gallery', $items = new NumericField('Items', _t('GalleryPage.ItemsLabel', 'Items')));
        $items->setRightTitle('How many items to display on each page');
        $fields->addFieldToTab('Root.Gallery', new CheckboxField('NoMargin', 'Remove margin from between gallery items'));

        /* -----------------------------------------
         * Gallery Images
        ------------------------------------------*/

        $fields->addFieldToTab('Root.Gallery', new HeaderField('Images'));
        $fields->addFieldToTab('Root.Gallery', $images = new UploadField('Images', _t('GalleryPage.ImagesLabel', 'Images'), $this->owner->Images()));
        $images->setFolderName('Uploads/gallery');

        return $fields;

    }

    /**
     * @return PaginatedList
     */
    public function PaginatedPages() {
        // Protect against "Division by 0" error
        if($this->Items == null || $this->Items == 0) $this->Items = 1;
        $pagination = new PaginatedList($this->Images(), Controller::curr()->request);
        $pagination->setPageLength($this->Items);
        return $pagination;
    }

}
class GalleryPage_Controller extends Page_Controller {

    /**
     * @return string
     */
    public function ThumbnailWidth(){
        switch($this->Columns){
            case 0:
                return '1140';
                break;
            default:
                return '722';
        }
    }

    /**
     * @return string
     */
    public function ThumbnailHeight(){
        switch($this->Columns){
            case 0:
                return '555';
                break;
            default:
                return '722';
        }
    }

}