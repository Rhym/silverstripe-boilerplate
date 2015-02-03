<?php

/**
 * Class GoogleFontConfig
 */
class GoogleFontConfig extends DataExtension {

    public static $db = array(
        'FontAPI' => 'Varchar(255)',
        'FontHeadings' => 'Varchar(255)',
        'FontBody' => 'Varchar(255)'
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields) {

        /* -----------------------------------------
         * Fonts
        ------------------------------------------*/

        $fields->findOrMakeTab('Root.Settings.GoogleFonts', 'Google Fonts');
        $fields->addFieldToTab('Root.Settings.GoogleFonts', $fontAPI = new TextField('FontAPI', _t('GoogleFontConfig.FontAPILabel', 'Google Fonts API Key')));
        if(!SiteConfig::current_site_config()->FontAPI){
            $fontAPI->setRightTitle('Once you\'ve saved your API key more font choices will be available');
        }

        if(SiteConfig::current_site_config()->FontAPI){
            $googleFontsArray = SiteConfig::current_site_config()->getGoogleFonts('all');
            $googleFontsDropdownArray[''] = '-- Theme Default --';
            foreach($googleFontsArray as $item) {
                $variants = ':'.implode(',', $item->variants);
                $googleFontsDropdownArray[$item->family.$variants] = $item->family;
            }
            $fields->addFieldsToTab('Root.Settings.GoogleFonts',
                array(
                    new DropdownField('FontHeadings', _t('GoogleFontConfig.FontHeadingsLabel', 'Headings'), $googleFontsDropdownArray),
                    new DropdownField('FontBody', _t('GoogleFontConfig.FontBodyLabel', 'Body'), $googleFontsDropdownArray)
                )
            );
        }

    }

    /**
     * @param int $amount
     * @return array
     */
    function getGoogleFonts( $amount = 30 ) {

        $fontFile = Director::baseFolder().'/'.BOILERPLATE_MODULE.'/fonts/google-web-fonts.txt';

        //Total time the file will be cached in seconds, set to a week
        $cacheTime = 86400 * 7;

        if(file_exists($fontFile) && $cacheTime < filemtime($fontFile)){
            $content = json_decode(file_get_contents($fontFile));
        } else {
            $url = 'https://www.googleapis.com/webfonts/v1/webfonts?key='.SiteConfig::current_site_config()->FontAPI;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_REFERER, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $fontContent = curl_exec($ch);
            curl_close($ch);

            $fp = fopen($fontFile, 'w');
            fwrite($fp, $fontContent);
            fclose($fp);

            $content = json_decode($fontContent);
        }
        if($amount == 'all'){
            return $content->items;
        } else {
            return array_slice($content->items, 0, $amount);
        }

    }

}