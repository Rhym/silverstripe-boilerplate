<?php

/**
 * Class PortfolioImage
 */
class PortfolioImage extends DataObject{

    private static $db = array (
        'SortOrder'         => 'Int',
        'ContentPosition'   => 'Enum(array("Full Width", "Left", "Right"))',
        'Content'           => 'HTMLText'
    );

    private static $has_one = array (
        'Page'  => 'Page',
        'Image' => 'Image'
    );

    private static $singular_name = 'Item';
    private static $plural_name = 'Items';

    public static $summary_fields = array(
        'Thumbnail'         => 'Thumbnail',
        'ContentPosition'   => 'Content Position',
        'ContentSummary'    => 'Content'
    );

    private static $defaults = array(
        'ContentPosition' => 'Full Width'
    );

    private static $default_sort = 'SortOrder';

    /**
     * @return RequiredFields
     */
    public function getCMSValidator() {
        return new RequiredFields(array(
            'ContentPosition',
            'Image'
        ));
    }

    /**
     * @return string
     */
    protected function getContentSummary() {
        if($this->Content) {
            $html = HTMLText::create();
            $html->setValue($this->dbObject('Content')->summary());
            return $html;
        }
        return '(none)';
    }

    /**
     * @return string
     */
    protected function getThumbnail() {
        if ($Image = $this->Image()->ID) {
            return $this->Image()->SetWidth(80);
        } else {
            return '(No Image)';
        }
    }

    /**
     * @return FieldList
     */
    public function getCMSFields() {
        $fields = FieldList::create(TabSet::create('Root'));

        $fields->addFieldToTab('Root.Main', HeaderField::create('', 'Image'));
        $fields->addFieldToTab('Root.Main', $image = UploadField::create('Image'));
        $image->setFolderName('Uploads/portfolio');
        $fields->addFieldToTab('Root.Main', $contentPosition = OptionsetField::create('ContentPosition', 'Content Position', $this->dbObject('ContentPosition')->enumValues()));
        $contentPosition->setRightTitle('Display the content on the left or right hand side.');
        $fields->addFieldToTab('Root.Main', $content = HtmlEditorField::create('Content'));
        $content->setRows(5);

        return $fields;
    }

    /**
     * On Before Write
     */
    protected function onBeforeWrite() {
        /**
         * Set SortOrder
         */
        if (!$this->SortOrder) {
            $this->SortOrder = PortfolioImage::get()->max('SortOrder') + 1;
        }
        parent::onBeforeWrite();
    }

}