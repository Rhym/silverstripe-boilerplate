<?php

/**
 * Class PortfolioPage
 *
 * @property string Subtitle
 *
 * @method PortfolioImage PortfolioImages
 */
class PortfolioPage extends Page
{
    /**
     * @var string
     */
    private static $icon = 'boilerplate/code/Modules/Portfolio/images/blog.png';

    /**
     * @var array
     */
    private static $db = array(
        'SubTitle' => 'Varchar(255)'
    );

    /**
     * @var array
     */
    private static $has_many = array(
        'PortfolioImages' => 'PortfolioImage'
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
    private static $singular_name = 'Portfolio Post';

    /**
     * @var string
     */
    private static $plural_name = 'Portfolio Posts';

    /**
     * @var array
     */
    private static $summary_fields = array(
        'Thumbnail' => 'Thumbnail',
        'Title' => 'Title',
        'SubTitle' => 'Sub Title',
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
     * @var string
     */
    private static $description = 'Portfolio content page';

    /**
     * Get the thumbnail of Image()
     *
     * @return Image|string
     */
    public function getThumbnail()
    {
        if ($this->PortfolioImages()->count() > 0) {
            return $this->PortfolioImages()->first()->getThumbnail();
        } else {
            return '(No Portfolio Images)';
        }
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        /** @var  $fields */
        $fields = parent::getCMSFields();

        $fields->removeByName('Slider');
        $fields->removeByName('PageBuilder');

        /** @var TextField $subTitle */
        $fields->addFieldToTab('Root.Main',
            $subTitle = TextField::create('SubTitle', _t('PortfolioPage.Subtitle', 'Sub Title')), 'Content');
        $subTitle->setRightTitle(_t('PortfolioPage.SubTitleRightTitle',
            'Subtitles are displayed on PortfolioHolder pages under the title.'));

        /** -----------------------------------------
         * Portfolio Images
         * ----------------------------------------*/

        $fields->addFieldToTab('Root.PortfolioImages',
            HeaderField::create('Heading', _t('PortfolioPage.Heading', 'Portfolio Images')));
        $fields->addFieldToTab('Root.PortfolioImages', LiteralField::create('Description',
            _t('PortfolioPage.Description',
                '<p>Portfolio Images are displayed under the page\'s content. Items can be full width, or have content displayed to the left or right hand side of the image.</p>')
        ));
        /** @var GridFieldConfig_RelationEditor $config */
        $config = GridFieldConfig_RelationEditor::create(10);
        $config->addComponent(new GridFieldOrderableRows('SortOrder'))
            ->addComponent(new GridFieldDeleteAction());
        $gridField = GridField::create(
            'PortfolioImages',
            'Images',
            $this->PortfolioImages(),
            $config
        );
        $fields->addFieldToTab('Root.PortfolioImages', $gridField);

        return $fields;

    }

    /**
     * @param SS_HTTPRequest $request
     * @return array|HTMLText
     */
    public function index(SS_HTTPRequest $request)
    {
        if ($request->isAjax()) {
            $data = $this->data();
            return $this->customise($data)
                ->renderWith('PortfolioPage_Item');
        }
        return array();
    }

}

/**
 * Class PortfolioPage_Controller
 */
class PortfolioPage_Controller extends Page_Controller
{
}
