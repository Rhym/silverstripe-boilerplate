<?php

/**
 * Class GalleryPage
 *
 * @property boolean NoMargin
 * @method ManyManyList Images
 */
class GalleryPage extends Page
{

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
    public function getCMSFields()
    {
        /** =========================================
         * @var UploadField $images
        ===========================================*/

        $fields = parent::getCMSFields();

        /** -----------------------------------------
         * Gallery Images
         * ----------------------------------------*/

        $fields->addFieldToTab('Root.Gallery', HeaderField::create('', 'Gallery'));
        $fields->addFieldToTab('Root.Gallery', LiteralField::create('',
            '<p>Images below are displayed in a carousel above the content. All images are rescaled to 1140px by 640px.</p>'
        ));
        $fields->addFieldToTab('Root.Gallery',
            $images = UploadField::create('Images', 'Images', $this->owner->Images()));
        $images->setFolderName('Uploads/gallery');
        $images->setAllowedExtensions(array(
            'jpg',
            'jpeg',
            'gif',
            'png'
        ));

        return $fields;

    }

    /**
     * @return PaginatedList
     */
    public function PaginatedPages()
    {
        /** =========================================
         * @var PaginatedList $pagination
        ===========================================*/

        /** Protect against "Division by 0" error */
        if ($this->Items == null || $this->Items == 0) {
            $this->Items = 10;
        }

        $pagination = PaginatedList::create($this->Images(), Controller::curr()->request);
        $pagination->setPageLength($this->Items);
        return $pagination;
    }

}

/**
 * Class GalleryPage_Controller
 */
class GalleryPage_Controller extends Page_Controller
{
}