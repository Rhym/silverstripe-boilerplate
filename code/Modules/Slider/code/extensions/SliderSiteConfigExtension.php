<?php

/**
 * Class SliderSiteConfigExtension
 */
class SliderSiteConfigExtension extends Extension {

    private static $db = array(
        'DefaultSliderHeight' => 'Varchar(255)'
    );

    private static $has_one = array(
        'SliderImage' => 'Image'
    );

    public static $defaults = array(
        'DefaultSliderHeight' => 0
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields) {

        if (!$fields->fieldByName('Root.Settings')){
            $fields->addFieldToTab('Root', TabSet::create('Settings'));
        }

        $fields->findOrMakeTab('Root.Settings.Slider', 'Slider');
        $fields->addFieldsToTab('Root.Settings.Slider',
            array(
                $image = UploadField::create('SliderImage'),
                $defaultSliderHeight = NumericField::create('DefaultSliderHeight', 'Default Height')
            )
        );
        $image->setFolderName('Uploads/slider');
        $image->setRightTitle('Image to be displayed on all pages as a default header. Can be overridden by a page\'s slider.');
        $defaultSliderHeight->setRightTitle('Height that will be set across the entire site, this can be overridden in individual pages');

    }

}