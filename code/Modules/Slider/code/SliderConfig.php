<?php

/**
 * Class SliderConfig
 */
class SliderConfig extends DataExtension {

    private static $db = array(
        'Height'            => 'Varchar(255)',
        'FullWidth'         => 'Boolean(1)',
        'HideDefaultSlider' => 'Boolean(0)'
    );

    private static $has_many = array(
        'SliderItems' => 'SliderItem'
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields) {

        $fields->addFieldToTab('Root.Slider', HeaderField::create('', 'Slider'));
        $fields->addFieldToTab('Root.Slider', LiteralField::create('',
            '<p>The slider is displayed below the header of the page. If there is more than one slide, the slider will become a carousel.</p>'
        ));
        $fields->addFieldToTab('Root.Slider', LiteralField::create('',
            '<div class="message"><p><strong>Note:</strong> A default slider image can be set across all pages under "Settings > Slider" in the left-hand menu</p></div>'
        ));
        $config = GridFieldConfig_RelationEditor::create(10);
        $config->addComponent(new GridFieldSortableRows('SortOrder'))
            ->addComponent(new GridFieldDeleteAction());
        $config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
            'Thumbnail' => 'Thumbnail'
        ));
        $gridField = GridField::create(
            'SliderItems',
            'Slides',
            $this->owner->SliderItems(),
            $config
        );
        $fields->addFieldToTab('Root.Slider', $gridField);

        /** -----------------------------------------
         * Settings
        -------------------------------------------*/

        $fields->addFieldToTab('Root.Slider', HeaderField::create('', 'Settings', 4));
        $fields->addFieldToTab('Root.Slider', CheckboxField::create('FullWidth', 'Set slider to be full width'));
        $fields->addFieldToTab('Root.Slider', $height = NumericField::create('Height', 'Height of slider (optional)'));
    }

    /**
     * @param FieldList $fields
     * @return FieldList
     */
    public function updateSettingsFields(FieldList $fields) {
        $fields->addFieldToTab('Root.Settings', $hideDefaultSlider = FieldGroup::create(
            CheckboxField::create('HideDefaultSlider', 'Hide the slider from this page')
        ));
        $hideDefaultSlider->setTitle('Slider');
        return $fields;
    }

    /**
     * @return bool|mixed
     *
     * If the page of SiteConfig has a max height set apply it to the Slider.
     */
    public function getSliderHeight() {
        if($height = $this->owner->Height) {
            return $height;
        } else if($siteConfigHeight = SiteConfig::current_site_config()->DefaultSliderHeight) {
            return $siteConfigHeight;
        }
        return false;
    }

    /**
     * @return string
     *
     * If the page, or SiteConfig has a slider item, then add the  "has-slider" class to the body, else add the  "no-slider".
     */
    public function getSliderClass() {
        ($this->owner->SliderItems()->First() || SiteConfig::current_site_config()->SliderImage()->Exists() ? $out = 'has-slider' : $out = 'no-slider');
        return $out;
    }

}