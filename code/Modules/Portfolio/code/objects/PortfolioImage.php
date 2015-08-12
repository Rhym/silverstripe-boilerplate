<?php

/**
 * Class PortfolioImage
 *
 * @property int SortOrder
 * @property enum ContentPosition
 * @property string Content
 * @method Page Page
 * @method Image Image
 */
class PortfolioImage extends DataObject
{

    /**
     * @var array
     */
    private static $db = array(
        'SortOrder' => 'Int',
        'ContentPosition' => 'Enum(array("Full Width", "Left", "Right"))',
        'Content' => 'HTMLText'
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Page' => 'Page',
        'Image' => 'Image'
    );

    /**
     * @var string
     */
    private static $singular_name = 'Item';

    /**
     * @var string
     */
    private static $plural_name = 'Items';

    /**
     * @var array
     */
    public static $summary_fields = array(
        'Thumbnail' => 'Thumbnail',
        'ContentPosition' => 'Content Position',
        'ContentSummary' => 'Content'
    );

    /**
     * @var array
     */
    private static $defaults = array(
        'ContentPosition' => 'Full Width'
    );

    /**
     * @var string
     */
    private static $default_sort = 'SortOrder';

    /**
     * @return RequiredFields
     */
    public function getCMSValidator()
    {
        return new RequiredFields(array(
            'ContentPosition',
            'Image'
        ));
    }

    /**
     * @return string
     */
    protected function getContentSummary()
    {
        /** =========================================
         * @var HTMLText $html
        ===========================================*/

        if ($this->Content) {
            $html = HTMLText::create();
            $html->setValue($this->dbObject('Content')->summary());
            return $html;
        }
        return '(none)';
    }

    /**
     * @return string
     */
    public function getThumbnail()
    {
        if ($this->Image()->ID) {
            return $this->Image()->CroppedImage(70, 39);
        } else {
            return '(No Image)';
        }
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        /** =========================================
         * @var FieldList $fields
         * @var UploadField $image
         * @var OptionsetField $contentPosition
         * @var HtmlEditorField $content
        ===========================================*/

        $fields = FieldList::create(TabSet::create('Root'));

        $fields->addFieldToTab('Root.Main', HeaderField::create('', 'Image'));
        $fields->addFieldToTab('Root.Main', $image = UploadField::create('Image'));
        $image->setFolderName('Uploads/portfolio');
        $image->setAllowedExtensions(array(
            'jpg',
            'jpeg',
            'gif',
            'png'
        ));
        $fields->addFieldToTab('Root.Main',
            $contentPosition = OptionsetField::create('ContentPosition', 'Content Position',
                $this->dbObject('ContentPosition')->enumValues()));
        $contentPosition->setRightTitle('Display the content on the left or right hand side.');
        $fields->addFieldToTab('Root.Main', $content = HtmlEditorField::create('Content'));
        $content->setRows(5);

        return $fields;
    }

    /**
     * Before Write
     */
    protected function onBeforeWrite()
    {
        /** Set SortOrder */
        if (!$this->SortOrder) {
            $this->SortOrder = PortfolioImage::get()->max('SortOrder') + 1;
        }
        parent::onBeforeWrite();
    }

}
