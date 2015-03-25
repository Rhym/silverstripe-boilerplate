<?php

/**
 * Class GalleryPage
 */
class GalleryPage extends Page {

    private static $icon = 'boilerplate/code/Modules/Gallery/images/folder-open-image.png';

    private static $db = array(
        'NoMargin' => 'Boolean'
    );

    public static $many_many = array(
        'Images' => 'Image'
    );

    private static $description = 'Displays a lightbox gallery of images';

    /**
     * @return FieldList
     */
    public function getCMSFields() {

        $fields = parent::getCMSFields();

        /* -----------------------------------------
         * Gallery Images
        ------------------------------------------*/

        $fields->addFieldToTab('Root.Gallery', new HeaderField('', 'Gallery'));
        $fields->addFieldToTab('Root.Gallery', new LiteralField('',
            '<p>Images below are displayed in a grid format (grid is set under "Main content > Display") as thumbnails, with the ability to open the images in full size.</p>'
        ));
        $fields->addFieldToTab('Root.Gallery', new CheckboxField('NoMargin', 'Remove margin from between images'));
        $fields->addFieldToTab('Root.Gallery', $images = new UploadField('Images', 'Images', $this->owner->Images()));
        $images->setFolderName('Uploads/gallery');

        return $fields;

    }

    /**
     * @return PaginatedList
     */
    public function PaginatedPages() {
        /**
         * Protect against "Division by 0" error
         */
        if($this->Items == null || $this->Items == 0) $this->Items = 10;

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