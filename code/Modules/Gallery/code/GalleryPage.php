<?php

/**
 * Class GalleryPage
 *
 * @property boolean NoMargin
 *
 * @method ManyManyList Images
 */
class GalleryPage extends Page
{
    /**
     * @var string
     */
    private static $icon = 'boilerplate/code/Modules/Gallery/images/folder-open-image.png';

    /**
     * @var array
     */
    private static $db = array(
        'NoMargin' => 'Boolean'
    );

    /**
     * @var array
     */
    public static $many_many = array(
        'Images' => 'Image'
    );

    /**
     * @var string
     */
    private static $description = 'Displays a lightbox gallery of images';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        /** @var FieldList $fields */
        $fields = parent::getCMSFields();

        /** -----------------------------------------
         * Gallery Images
         * ----------------------------------------*/

        $fields->addFieldToTab('Root.Gallery', HeaderField::create('', 'Gallery'));
        $fields->addFieldToTab('Root.Gallery', LiteralField::create('',
            '<p>Images below are displayed in a carousel above the content. All images are rescaled to 1140px by 640px.</p>'
        ));
        /** @var UploadField $images */
        $fields->addFieldToTab('Root.Gallery',
            $images = UploadField::create('Images', 'Images', $this->Images()));
        $images->setFolderName('Uploads/gallery');
        $images->setAllowedExtensions(array(
            'jpg',
            'jpeg',
            'gif',
            'png'
        ));

        return $fields;

    }

}

/**
 * Class GalleryPage_Controller
 */
class GalleryPage_Controller extends Page_Controller
{
}
