<?php

/**
 * Class PageItemConfig
 */
class PageItemConfig extends DataExtension {

    private static $has_many = array(
        'PageItems' => 'PageItem'
    );

    /**
     * @param FieldList $fields
     * TODO: Render Page Builder View as a Layout, not as generated HTML
     */
    public function updateCMSFields(FieldList $fields) {

        /* -----------------------------------------
         * Page Items
        ------------------------------------------*/

        $config = GridFieldConfig_RelationEditor::create(100);
        $config->addComponent(new GridFieldSortableRows('SortOrder'))
            ->addComponent(new GridFieldDeleteAction());
        $gridField = new GridField(
            'PageItemItems',
            _t('PageItemConfig.PageImageItemsLabel', 'Items'),
            $this->owner->PageItems(),
            $config
        );
        //$fields->addFieldToTab('Root.PageBuilder', $gridField);

        /* -----------------------------------------
         * Page Builder View
        ------------------------------------------*/

        if($this->owner->PageItems()->Count() > 0) {
            $out = '<ul class="gridster pagebuilder-collection">';
            // Count the component divs, so if there's not enough closing components, append one to the end of the document.
            $componentOpenCount = 0;
            $componentCloseCount = 0;
            foreach ($this->owner->PageItems() as $key => $val) {
                switch ($val->Size) {
//                    case 'col-sm-9':
//                        $sizeLabel = '3/4';
//                        $dataSize = 'data-sizex="10" data-sizey="1"';
//                        break;
//                    case 'col-sm-8':
//                        $sizeLabel = '2/3';
//                        $dataSize = 'data-sizex="10" data-sizey="1"';
//                        break;
                    case 'col-sm-6':
                        $sizeLabel = '1/2';
                        $dataSize = 'data-sizex="5" data-sizey="1"';
                        break;
//                    case 'col-sm-4':
//                        $sizeLabel = '1/3';
//                        $dataSize = 'data-sizex="3" data-sizey="1"';
//                        break;
                    case 'col-sm-3':
                        $sizeLabel = '1/4';
                        $dataSize = 'data-sizex="2" data-sizey="1"';
                        break;
                    default:
                        $sizeLabel = 'Full';
                        $dataSize = 'data-sizex="10" data-sizey="1"';
                        break;
                }
                switch ($val->Type) {

                    /* -----------------------------------------
                     * Default
                    ------------------------------------------*/
                    default:
                        $out.= '<li data-row="1" data-col="1" '.$dataSize.'><div class="inner">'.$val->Title.'</div></li>';
                        break;
                }
            }
            $out .= '</ul>';
            $fields->addFieldToTab('Root.PageBuilder', new LiteralField('PageBuilderDisplay', $out));
        }
    }

}

class PageItemControllerExtension extends Extension {

    public function onBeforeInit() {

        /* =========================================
         * CSS
         =========================================*/

        if($this->owner->PageItems()->Count() > 0) {
            $style = '';
            foreach ($this->owner->PageItems() as $key => $item) {
                if (isset($item->StyleValue)) {
                    $style .= $item->Style->GenerateCSS($item->BackgroundImage());
                }
            }
            Requirements::customCSS($style);
        }
    }

}