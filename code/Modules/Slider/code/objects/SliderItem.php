<?php

/**
 * Class SliderItem
 */
class SliderItem extends DataObject{

    private static $db = array (
        'SortOrder'     => 'Int',
        'Caption'       => 'HTMLText'
    );

    private static $has_one = array (
        'Page'          => 'Page',
        'Image'         => 'Image'
    );

    private static $singular_name = 'Slide';
    private static $plural_name = 'Slides';

    public static $summary_fields = array(
  		'Thumbnail' => 'Thumbnail'
 	);

    public function getCMSValidator() {
        return RequiredFields::create(array(
            'Image'
        ));
    }

    private static $default_sort = 'SortOrder';

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

        $fields->addFieldToTab('Root.Main', HeaderField::create('', 'Slide'));
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
        $fields->addFieldToTab('Root.Main', $caption = HtmlEditorField::create('Caption'));
        $caption->setRows(15);

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
            $this->SortOrder = SliderItem::get()->max('SortOrder') + 1;
        }
        parent::onBeforeWrite();
    }

}