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

        $fields->findOrMakeTab('Root.Settings.Banner', 'Banner');
        $fields->addFieldsToTab('Root.Settings.Banner',
            array(
                HeaderField::create('', 'Banner'),
                LiteralField::create('',
                    '<p>Image to be displayed on all pages as a default banner. Can be overridden by a page\'s banner.</p>'
                ),
                $image = UploadField::create('SliderImage', 'Image'),
                $defaultSliderHeight = NumericField::create('DefaultSliderHeight', 'Default Height')
            )
        );
        $image->setFolderName('Uploads/slider');
        $defaultSliderHeight->setRightTitle('Height that will be set across the entire site, this can be overridden in individual pages');

    }

}