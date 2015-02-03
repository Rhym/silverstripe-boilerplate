<?php

/**
 * Class SliderConfig
 */
class SliderConfig extends DataExtension {

    private static $db = array(
        'Height' => 'Varchar(255)',
        'FullWidth' => 'Boolean(1)'
    );

    private static $has_many = array(
        'SliderItems' => 'SliderItem'
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields) {
        $config = GridFieldConfig_RelationEditor::create(10);
        $config->addComponent(new GridFieldSortableRows('SortOrder'))
            ->addComponent(new GridFieldDeleteAction());
        $config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
            'Thumbnail' => 'Thumbnail'
        ));
        $gridField = new GridField(
            'SliderItems',
            _t('SliderConfig.SliderItemsLabel', 'Slider Items'),
            $this->owner->SliderItems(),
            $config
        );
        $fields->addFieldToTab('Root.Slider', $gridField);

        /* -----------------------------------------
         * Settings
        ------------------------------------------*/

        $fields->addFieldToTab('Root.Slider', new HeaderField('Settings'));
        $fields->addFieldToTab('Root.Slider', new CheckboxField('FullWidth', _t('SliderConfig.FullWidthLabel', 'Set slider to be full width')));
        $fields->addFieldToTab('Root.Slider', $height = new NumericField('Height', _t('SliderConfig.HeightLabel', 'Height of slider (optional)')));
    }

    /**
     * @return bool|mixed
     *
     * If the page of SiteConfig has a max height set apply it to the Slider.
     */
    public function getSliderHeight() {
        if($height = $this->owner->Height){
            return $height;
        }else if($siteConfigHeight = SiteConfig::current_site_config()->DefaultSliderHeight){
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