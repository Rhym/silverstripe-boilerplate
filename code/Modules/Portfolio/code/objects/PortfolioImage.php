<?php

/**
 * Class PortfolioImage
 */
class PortfolioImage extends DataObject{

    private static $db = array (
        'SortOrder' => 'Int',
        'ContentPosition' => 'Enum(array("Left", "Right"))',
        'Content' => 'HTMLText'
    );

    private static $has_one = array (
        'Page' => 'Page',
        'Image' => 'Image'
    );

    private static $singular_name = 'Item';
    private static $plural_name = 'Items';

    public static $summary_fields = array(
        'Thumbnail' => 'Thumbnail',
        'ContentPosition' => 'Content Position',
        'ContentSummary' => 'Content'
    );

    private static $defaults = array(
        'TextPosition' => 'Left'
    );

    private static $default_sort = 'SortOrder';

    /**
     * @return RequiredFields
     */
    public function getCMSValidator() {
        return new RequiredFields(array(
            'TextPosition',
            'Image'
        ));
    }

    /**
     * @return string
     */
    public function getContentSummary() {
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
    public function getThumbnail() {
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

        $fields->addFieldToTab('Root.Main', new HeaderField('', 'Image'));
        $fields->addFieldToTab('Root.Main', $image = new UploadField('Image'));
        $image->setFolderName('Uploads/portfolio');
        $fields->addFieldToTab('Root.Main', $contentPosition = new OptionsetField('ContentPosition', 'Content Position', $this->dbObject('ContentPosition')->enumValues()));
        $contentPosition->setRightTitle('Display the content on the left or right hand side.');
        $fields->addFieldToTab('Root.Main', $content = new HtmlEditorField('Content'));
        $content->setRows(5);

        return $fields;
    }

}