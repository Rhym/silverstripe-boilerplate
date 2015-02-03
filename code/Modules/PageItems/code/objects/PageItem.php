<?php

/**
 * Class PageItem
 */
class PageItem extends DataObject {

    private static $db = array (
        'Title' => 'Varchar(255)',
        'Type' => 'Enum(array("Content", "Image", "Slider", "Component Open", "Component Close"))',
        'Content' => 'HTMLText',
        'Size' => 'Text',
        'SortOrder' => 'Int',
        'ExternalLink' => 'Varchar(255)',
        'ClearRow' => 'Boolean(0)',
        'FullWidth' => 'Boolean(0)',
        'RemoveMargins' => 'Boolean(0)',
        'Style' => 'MultiValueField',
        'Animated' => 'Enum(array("fadeIn", "fadeInUp", "fadeInRight", "fadeInDown", "fadeInLeft"))'
    );

    private static $has_one = array (
        'Page' => 'Page',
        'Image' => 'Image',
        'HoverImage' => 'Image',
        'Link' => 'SiteTree',
        'BackgroundImage' => 'Image'
    );

    private static $many_many = array (
        'SliderImages' => 'Image'
    );

    private static $summary_fields = array(
        'SummaryType' => 'Type',
        'SummaryContent' => 'Reference',
        'SortOrder' => 'SortID'
    );

    private static $default_sort = 'SortOrder';

    /**
     * @return FieldList
     */
    public function getCMSFields() {

        $fields = FieldList::create(TabSet::create('Root'));

        $fields->addFieldToTab('Root.Main', new HeaderField('', 'Settings'));
        $fields->addFieldToTab('Root.Main', new OptionsetField('Type', 'Type', singleton('PageItem')->dbObject('Type')->enumValues()));

        /**
         * Check if Type has been set, otherwise prompt the user to choose
         */
        if($this->Type) {

            $fields->addFieldToTab('Root.Main', $titleField = new TextField('Title'));
            $titleField->setRightTitle('Title is used to reference this item in the page builder.');
            $fields->addFieldToTab('Root.Main', new DropdownField('Size', 'Size', array(
                'col-sm-12' => 'Full',
                'col-sm-6' => '1/2',
                'col-sm-4' => '1/3',
                'col-sm-8' => '2/3',
                'col-sm-3' => '1/4',
                'col-sm-9' => '2/4'
            )));
            $fields->addFieldToTab('Root.Settings', $animated = new DropdownField('Animated', 'Animated', singleton('PageItem')->dbObject('Animated')->enumValues(), '', 'No Animation'));
            $fields->addFieldToTab('Root.Settings', $clearRow = new CheckboxField('ClearRow'));

            switch ($this->Type) {
                case 'Component Open':
                    $fields->removeByName('Title');
                    $fields->removeByName('Size');
                    $fields->removeByName('Settings');
                    $fields->removeByName('Animated');
                    $fields->addFieldToTab('Root.Main', new HeaderField('', 'Settings', 4));
                    $fields->addFieldToTab('Root.Main', new CheckboxField('FullWidth', 'Make the component full width'));
                    $fields->addFieldToTab('Root.Main', new CheckboxField('RemoveMargins', 'Remove spacing between items'));
                    $fields->addFieldToTab('Root.Main', $componentOpenStyle = new StyleField('Style'));
                    $componentOpenStyle->setSelector('.component-'.$this->ID);
                    $fields->addFieldToTab('Root.Main', $backgroundImage = new UploadField('BackgroundImage', 'Image'));
                    $backgroundImage->setFolderName('Uploads/page-builder');
                    break;
                case 'Component Close':
                    $fields->removeByName('Title');
                    $fields->removeByName('Size');
                    $fields->removeByName('Animation');
                    break;
                case 'Image':
                    $fields->removeByName('Title');
                    $fields->addFieldToTab('Root.Main', new HeaderField('', 'Images'));
                    $fields->addFieldToTab('Root.Main', $image = new UploadField('Image'));
                    $image->setFolderName('Uploads/page-builder');
                    $fields->addFieldToTab('Root.Main', $hoverImage = new UploadField('HoverImage'));
                    $hoverImage->setRightTitle('(optional) will replace the current image on hover. Images should be the same size.');
                    $hoverImage->setFolderName('Uploads/page-builder');
                    $fields->addFieldToTab('Root.Main', new HeaderField('', 'Links'));
                    $fields->addFieldToTab('Root.Main', new TreeDropdownField('LinkID', 'Internal Link', 'SiteTree'));
                    $fields->addFieldToTab('Root.Main', $externalLink = new TextField('ExternalLink'));
                    $externalLink->setRightTitle('Overrides Internal Link (URLs must start with "http://")');
                    break;
                case 'Slider':
                    $fields->addFieldToTab('Root.Main', new HeaderField('', 'Slider'));
                    $fields->addFieldToTab('Root.Main', $sliderImages = new UploadField('SliderImages', 'Slider Images', $this->SliderImages()));
                    $sliderImages->setFolderName('Uploads/page-builder/sliders');
                    break;
                default:
                    $fields->addFieldToTab('Root.Main', new HtmlEditorField('Content', _t('PageItem.ContentLabel', 'Content')));
            }

        }else{
            $fields->addFieldToTab('Root.Main', new LiteralField('', '<div class="message warning">Select the type, and save the Page Item to show the relevant fields</div>'));
        }

        return $fields;

    }

    /**
     * @return mixed
     * Used in the CMS to display icons/text relative to the PageItem in the $summary_fields
     * TODO: Use a Layout instead of generating HTML in the backend
     */
    public function SummaryType() {
        switch($this->Type) {
            case 'Component Open':
                $icons = '<img src="'.BOILERPLATE_MODULE.'/code/Modules/PageItems/images/ui-tab.png" alt="Component Open" />';
                if($this->FullWidth){
                    $icons .= '&nbsp;<img src="'.BOILERPLATE_MODULE.'/code/Modules/PageItems/images/arrow-resize.png" alt="Full Width" />';
                }
                return DBField::create_field('HTMLVarchar', $icons);
                break;
            case 'Component Close':
                return DBField::create_field('HTMLVarchar', '<img src="'.BOILERPLATE_MODULE.'/code/Modules/PageItems/images/ui-tab-bottom.png" alt="Component Close" />');
                break;
            case 'Image':
                return DBField::create_field('HTMLVarchar', '<img src="'.BOILERPLATE_MODULE.'/code/Modules/PageItems/images/image.png" alt="Image" />');
                break;
            case 'Slider':
                return DBField::create_field('HTMLVarchar', '<img src="'.BOILERPLATE_MODULE.'/code/Modules/PageItems/images/folder-open-image.png" alt="Slider" />');
                break;
            default:
                return DBField::create_field('HTMLVarchar', '<img src="'.BOILERPLATE_MODULE.'/code/Modules/PageItems/images/selection-input.png" alt="Content" />');
        }
    }

    /**
     * @return mixed
     */
    public function SummaryContent() {
        switch($this->Type) {
            case 'Image':
                return $this->Image()->croppedImage(40, 30);
                break;
            case 'Slider':
                $images = '';
                if($this->SliderImages()->Count() > 0) {
                    foreach ($this->SliderImages() as $image) {
                        $images .= '<img src="' . $image->croppedImage(40, 30)->URL . '" />&nbsp;';
                    }
                }
                return DBField::create_field('HTMLVarchar', $images);
                break;
            default:
                return $this->Title;
        }
    }

    /**
     * @param $value
     * @param null $backgroundImage
     * @return string
     * Creates CSS for the values saved by the StyleField
     * TODO: Compile CSS to separate file
     */
    public function generateCSS($value, $backgroundImage){
        $out = '';

        // Padding
        $out .= '@media (min-width: 768px){'.$value[0].'{';
        $out .= (isset($value[1]) ? 'padding-top: '.$value[1].'px;' : '');
        $out .= (isset($value[2]) ? 'padding-right: '.$value[2].'px;' : '');
        $out .= (isset($value[3]) ? 'padding-bottom: '.$value[3].'px;' : '');
        $out .= (isset($value[4]) ? 'padding-left: '.$value[4].'px;' : '');

        // Margin
        $out .= (isset($value[5]) ? 'margin-top: '.$value[5].'px;' : '');
        $out .= (isset($value[6]) ? 'margin-right: '.$value[6].'px;' : '');
        $out .= (isset($value[7]) ? 'margin-bottom: '.$value[7].'px;' : '');
        $out .= (isset($value[8]) ? 'margin-left: '.$value[8].'px;' : '');
        $out .= '}}';

        // Colors
        $out .= '.component-'.$this->ID.'{';
        $out .= (isset($value[9]) ? 'color: '.$value[9].';' : '');
        $out .= (isset($value[11]) ? 'background-color: '.$value[11].';' : '');
        $out .= (isset($backgroundImage) ? 'background-image: url('.$backgroundImage->URL.');' : '');
        $out .= '}';
        $out .= $value[0].' h1,'.
            $value[0].' h2,'.
            $value[0].' h3,'.
            $value[0].' h4,'.
            $value[0].' h5,'.
            $value[0].' h6{'.(isset($value[10]) ? 'color: '.$value[10].';' : '').'}';

        return $out;
    }

    /**
     * @return bool|mixed
     * Used in the front end to display the link if it's external, or internal.
     */
    public function getLinkSwitch() {
        if($externalLink = $this->ExternalLink){
            return $externalLink;
        }else if($this->Link()->Exists()){
            return $this->Link()->Link();
        }
        return false;
    }

    /**
     * @return mixed
     * Used in the CMS to display the image in the page builder view.
     */
    public function Thumbnail(){
        if($this->Type == 'Slider'){
            return $this->SliderImages()->First();
        }
        return $this->Image();
    }

    /**
     * @return mixed
     * Use the correct template depending on the PageItem Type.
     */
    public function Render() {
        switch($this->Type){
            case 'Component Open':
                return $this->renderWith('PageItem_ComponentOpen');
                break;
            case 'Component Close':
                return $this->renderWith('PageItem_ComponentClose');
                break;
            case 'Image':
                return $this->renderWith('PageItem_Image');
                break;
            case 'Slider':
                return $this->renderWith('PageItem_Slider');
                break;
            default:
                return $this->renderWith('PageItem');
                break;
        }
    }

}