<?php

/**
 * Class SliderItem
 *
 * @property int SortOrder
 * @property string Caption
 *
 * @method Page Page
 * @method Image Image
 */
class SliderItem extends DataObject
{
    /**
     * @var array
     */
    private static $db = array(
        'SortOrder' => 'Int',
        'Caption' => 'HTMLText'
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
    private static $singular_name = 'Slide';

    /**
     * @var string
     */
    private static $plural_name = 'Slides';

    /**
     * @var array
     */
    public static $summary_fields = array(
        'Thumbnail' => 'Thumbnail'
    );

    /**
     * @var string
     */
    private static $default_sort = 'SortOrder';

    /**
     * @return mixed
     */
    public function getCMSValidator()
    {
        return RequiredFields::create(array(
            'Image'
        ));
    }

    /**
     * @return string
     */
    protected function getThumbnail()
    {
        if ($Image = $this->Image()->ID) {
            return $this->Image()->SetWidth(80);
        } else {
            return '(No Image)';
        }
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        /** @var FieldList $fields */
        $fields = FieldList::create(TabSet::create('Root'));

        $fields->addFieldToTab('Root.Main', HeaderField::create('', 'Slide'));
        /** @var UploadField $image */
        $fields->addFieldToTab('Root.Main', $image = UploadField::create('Image'));
        $image->setFolderName('Uploads/slider');
        $image->setAllowedExtensions(array(
            'jpg',
            'jpeg',
            'gif',
            'png'
        ));
        $fields->addFieldToTab('Root.Main', LiteralField::create('',
            '<div class="message"><p><strong>Note:</strong> Captions are optional</p></div>'
        ));
        /** @var HtmlEditorField $caption */
        $fields->addFieldToTab('Root.Main', $caption = HtmlEditorField::create('Caption'));
        $caption->setRows(15);

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    /**
     * On Before Write
     */
    protected function onBeforeWrite()
    {
        /** Set SortOrder */
        if (!$this->SortOrder) {
            $this->SortOrder = DataObject::get($this->ClassName)->max('SortOrder') + 1;
        }
        parent::onBeforeWrite();
    }

}
