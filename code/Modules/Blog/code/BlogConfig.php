<?php

/**
 * Class BlogConfig
 */
class BlogConfig extends DataExtension {

    public static $db = array(
		'DisqusForumShortName' => 'Varchar(255)'
	);

	public static $defaults = array();

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields) {

        /** -----------------------------------------
         * Comments
        -------------------------------------------*/

        $fields->findOrMakeTab('Root.Settings.Comments', 'Comments');
        $fields->addFieldsToTab('Root.Settings.Comments',
            array(
                $disqusForumShortName = new TextField('DisqusForumShortName', 'Disqus forum shortname')
            )
        );
        if(!SiteConfig::current_site_config()->DisqusForumShortName){
            $disqusForumShortName->setRightTitle('Enables Disqus commenting on blog items. Sign up for your Disqus account at: <a href="http://disqus.com/" target="_blank">http://disqus.com/</a>');
        }

    }

}