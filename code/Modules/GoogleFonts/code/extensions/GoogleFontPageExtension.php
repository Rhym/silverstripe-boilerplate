<?php

/**
 * Class GoogleFontPageExtension
 */
class GoogleFontPageExtension extends Extension {

    public function onAfterInit() {

        /* =========================================
         * Add Google Font CSS
         =========================================*/

        if(SiteConfig::current_site_config()->FontHeadings){
            $font = SiteConfig::current_site_config()->FontHeadings;
            // Strip out font variants after colon
            $fontName = substr($font, 0, strpos($font,':'));
            Requirements::css('http://fonts.googleapis.com/css?family='.SiteConfig::current_site_config()->FontHeadings);
            Requirements::customCSS(<<<CSS
h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6{font-family: $fontName, serif;}
CSS
            );
        }

        if(SiteConfig::current_site_config()->FontBody){
            $font = SiteConfig::current_site_config()->FontBody;
            // Strip out font variants after colon
            $fontName = substr($font, 0, strpos($font,':'));
            Requirements::css('http://fonts.googleapis.com/css?family='.SiteConfig::current_site_config()->FontBody);
            Requirements::customCSS(<<<CSS
body, strong, input, textarea, #main-nav .nav li a, .btn{font-family: $fontName, serif;}::-webkit-input-placeholder{font-family: $fontName, serif;}::-moz-placeholder{font-family: $fontName, serif;}:-ms-input-placeholder{font-family: $fontName, serif;}input:-moz-placeholder{font-family: $fontName, serif;}
CSS
            );
        }

    }

}