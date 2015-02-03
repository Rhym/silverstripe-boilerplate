<?php

/**
 * Class PortfolioImage
 */
class PortfolioImage extends DataObject{

    private static $db = array (
        'SortOrder' => 'Int',
        'Content' => 'HTMLText',
        'TextRight' => 'Boolean(0)'
    );

    private static $has_one = array (
        'Page' => 'Page',
        'Image' => 'Image'
    );

    public static $summary_fields = array(
        'Thumbnail'=>'Thumbnail'
    );

    private static $default_sort = 'SortOrder';

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

        $fields->addFieldToTab('Root.Main', $image = new UploadField('Image'));
        $image->setFolderName('Uploads/portfolio');
        $fields->addFieldToTab('Root.Main', new CheckboxField('TextRight', 'Display the content on the right hand side'));
        $fields->addFieldToTab('Root.Main', new HtmlEditorField('Content'));

        return $fields;
    }

}