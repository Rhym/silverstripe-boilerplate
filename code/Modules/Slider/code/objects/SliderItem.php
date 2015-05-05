<?php

/**
 * Class SliderItem
 */
class SliderItem extends DataObject{

    private static $db = array (
        'SortOrder'     => 'Int',
        'Caption'       => 'HTMLText',
        'ExternalLink'  => 'Text'
    );

    private static $has_one = array (
        'Page'          => 'Page',
        'Image'         => 'Image',
        'InternalLink'  => 'SiteTree'
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

        $fields->addFieldToTab('Root.Main', HeaderField::create('', 'Slide'));
        $fields->addFieldToTab('Root.Main', $image = UploadField::create('Image'));
        $image->setFolderName('Uploads/slider');
        $fields->addFieldToTab('Root.Main', LiteralField::create('',
            '<div class="message"><p><strong>Note:</strong> Captions and links are optional</p></div>'
        ));
        $fields->addFieldToTab('Root.Main', $caption = HtmlEditorField::create('Caption'));
        $caption->setRows(15);
        $fields->addFieldToTab('Root.Main', HeaderField::create('', 'Link', 4));
        $fields->addFieldToTab('Root.Main', TreeDropdownField::create('InternalLinkID', 'Internal Link', 'SiteTree'));
        $fields->addFieldToTab('Root.Main', $externalLink = TextField::create('ExternalLink', 'External Link'));
        $externalLink->setRightTitle('Must begin with "http://" this will override the Internal Link if set.');

        return $fields;
    }

    /**
     * @return bool|mixed]
     *
     * Return the link whether it be internal, or external.
     */
    public function getFormattedLink() {
        if($internalLink = $this->ExternalLink) {
            return $internalLink;
        } else if($externalLink = $this->InternalLink()->Exists()){
            return $this->InternalLink()->Link();
        }
        return false;
    }

}