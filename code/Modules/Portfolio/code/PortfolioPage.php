<?php

/**
 * Class PortfolioPage
 *
 * @property string Subtitle
 *
 * @method HasManyList PortfolioImages
 */
class PortfolioPage extends Page {

    private static $icon = 'boilerplate/code/Modules/Portfolio/images/blog.png';

    private static $db = array(
        'SubTitle' => 'Varchar(255)'
    );

    private static $has_many = array(
        'PortfolioImages' => 'PortfolioImage'
    );

    private static $defaults = array(
        'ShowInMenus' => 0
    );

    private static $singular_name = 'Portfolio Post';

    private static $plural_name = 'Portfolio Posts';

    private static $summary_fields = array(
        'Thumbnail'         => 'Thumbnail',
        'Title'             => 'Title',
        'SubTitle'          => 'Sub Title',
        'Content.Summary'   => 'Summary'
    );

    private static $allowed_children = 'none';

    private static $can_be_root = false;

    private static $description = 'Portfolio content page';

    /**
     * Get the thumbnail of Image()
     *
     * @return Image|string
     */
    public function getThumbnail() {
        if ($this->PortfolioImages()->count() > 0) {
            return $this->PortfolioImages()->first()->getThumbnail();
        } else {
            return '(No Portfolio Images)';
        }
    }

    /**
     * @return FieldList
     */
    public function getCMSFields() {
        /** =========================================
         * @var TextField                       $subTitle
         * @var GridFieldConfig_RelationEditor  $config
        ===========================================*/

        $fields = parent::getCMSFields();

        $fields->removeByName('Slider');
        $fields->removeByName('PageBuilder');

        $fields->addFieldToTab('Root.Main', $subTitle = TextField::create('SubTitle', 'Sub Title'), 'Content');
        $subTitle->setRightTitle('Subtitles are displayed on PortfolioHolder pages under the title.');

        /** -----------------------------------------
         * Portfolio Images
        -------------------------------------------*/

        $fields->addFieldToTab('Root.PortfolioImages', HeaderField::create('', 'Portfolio Images'));
        $fields->addFieldToTab('Root.PortfolioImages', LiteralField::create('',
            '<p>Portfolio Images are displayed under the page\'s content. Items can be full width, or have content displayed to the left or right hand side of the image.</p>'
        ));
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
     * @return $this|HTMLText
     */
    public function index(SS_HTTPRequest $request) {
        if($request->isAjax()) {
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
class PortfolioPage_Controller extends Page_Controller {}