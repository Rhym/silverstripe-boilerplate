<?php

/**
 * Class BlogPage
 *
 * @property string Date
 * @property string Author
 *
 * @method Image Image
 */
class BlogPage extends Page
{
    /**
     * @var string
     */
    private static $icon = 'boilerplate/code/Modules/Blog/images/blog.png';

    /**
     * @var array
     */
    private static $db = array(
        'Date' => 'Date',
        'Author' => 'Text'
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Image' => 'Image'
    );

    /**
     * @var array
     */
    private static $defaults = array(
        'ShowInMenus' => 0
    );

    /**
     * @var string
     */
    private static $description = 'Blog content page';

    /**
     * @var string
     */
    private static $singular_name = 'Blog Post';

    /**
     * @var string
     */
    private static $plural_name = 'Blog Posts';

    /**
     * @var array
     */
    private static $summary_fields = array(
        'Thumbnail' => 'Thumbnail',
        'Title' => 'Title',
        'Date.Nice' => 'Date',
        'Author' => 'Author',
        'Content.Summary' => 'Summary'
    );

    /**
     * @var string
     */
    private static $allowed_children = 'none';

    /**
     * @var bool
     */
    private static $can_be_root = false;

    /**
     * @var array
     */
    public static $many_many_extraFields = array(
        'Tags' => array(
            'SortOrder' => 'Int'
        )
    );

    /**
     * Get the thumbnail of Image()
     *
     * @return Image|string
     */
    public function getThumbnail()
    {
        if ($this->Image()->ID) {
            return $this->Image()->croppedImage(70, 39);
        } else {
            return '(none)';
        }
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        /** @var FieldList $fields */
        $fields = parent::getCMSFields();

        /** @var UploadField $blogImage */
        $fields->addFieldToTab('Root.Main', $blogImage = UploadField::create('Image', _t('BlogPage.Image', 'Image')),
            'Content');
        $blogImage->setRightTitle(_t('BlogPage.ImageRightTitle',
            'Image is used on BlogHolder pages as a thumbnail, as well as at the top of this page\'s content.'));
        $blogImage->setFolderName('Uploads/blog');
        $blogImage->setAllowedExtensions(array(
            'jpg',
            'jpeg',
            'gif',
            'png'
        ));
        /** @var DateField $dateField */
        $fields->addFieldToTab('Root.Main',
            $dateField = DateField::create('Date', _t('BlogPage.Date', 'Article Date (optional)')),
            'Content');
        $dateField->setConfig('showcalendar', true);
        $fields->addFieldToTab('Root.Main', TextField::create('Author', _t('BlogPage.Author', 'Author (optional)')),
            'Content');

        return $fields;

    }

    /**
     * @param SS_HTTPRequest $request
     * @return $this|HTMLText
     */
    public function index(SS_HTTPRequest $request)
    {
        if ($request->isAjax()) {
            $data = $this->data();
            return $this->customise($data)
                ->renderWith('BlogPage_Item');
        }
        return array();
    }

}

/**
 * Class BlogPage_Controller
 */
class BlogPage_Controller extends Page_Controller
{

    public function init()
    {
        parent::init();
        /**
         * If there's a Disqus forum name set,
         * include the javascript template that will
         * initiate the comments section.
         */
        if ($forumName = SiteConfig::current_site_config()->DisqusForumShortName) {
            $vars = array(
                'ForumName' => $forumName,
            );
            Requirements::javascriptTemplate(JS_DIR . '/comments.js', $vars);
        }
    }

}
