<?php

require_once Director::baseFolder().'/'.NEWSLETTER_MODULE_DIR.'/thirdparty/Mailchimp.php';

/**
 * Class NewsletterAdmin
 */
class NewsletterAdmin extends LeftAndMain {

    private static $menu_icon = 'boilerplate/code/Modules/Newsletter/images/envelope_menu.png';
    private static $url_segment = 'newsletter';
    private static $url_priority = 100;
    private static $menu_title = 'Newsletter';

    public static $hidden_sections = array();

    private static $allowed_actions = array(
        'getAPIForm',
        'campaigns',
        'viewCampaign',
        'lists',
        'viewList',
        'getListForm',
        'saveGroup',
        'getCampaignForm',
        'createCampaign',
        'deleteCampaign'
    );

    /**
     * @return SS_HTTPResponse|string|void
     */
    public function init() {
        parent::init();
        Requirements::javascript(NEWSLETTER_MODULE_DIR.'/javascript/mailchimp.js');
        Requirements::css(NEWSLETTER_MODULE_DIR.'/css/newsletter.css');
    }

    /**
     * @return TabSet
     */
    public function getMainContent(){

        /* -----------------------------------------
         * Root
        ------------------------------------------*/

        $tabSet = new TabSet('Root', 'Root');

        /* -----------------------------------------
         * Campaigns
        ------------------------------------------*/

        if(self::hasAPI()){
            $campaignTab = new Tab('Campaigns', 'Campaigns');
            $tabSet->push($campaignTab);
            $campaignContent = '<button id="campaignsButton" class="ss-ui-button ss-ui-action-constructive" data-icon="add" role="button">Load Campaigns</button>';
            $campaignContent.= '<button id="newCampaignButton" class="ss-ui-button" role="button">New Campaign</button>';
            $campaignContent.= '<div id="MailchimpCampaignsUL"></div>';
            $campaignTab->push(new LiteralField('Campaigns', $campaignContent));
        }

        /* -----------------------------------------
         * Lists
        ------------------------------------------*/

        if(self::hasAPI()){
            $listTab = new Tab('Lists', 'Lists');
            $tabSet->push($listTab);
            $listContent = '<button id="listsButton" class="ss-ui-button ss-ui-action-constructive" data-icon="add" role="button">Load Lists</button>';
            $listContent.= '<ul id="MailchimpListsUL"></ul>';
            $listTab->push(new LiteralField('Lists', $listContent));
        }

        /* -----------------------------------------
         * @return
        ------------------------------------------*/

        return $tabSet;
    }

    /**
     * @return Mailchimp
     */
    public function Connect(){
        $config = SiteConfig::current_site_config();
        if(!$config->MailChimpAPI)return;
        try {
            $this->mc = new Mailchimp($config->MailChimpAPI);
        } catch (Mailchimp_Error $e) {
            $this->error($e);
        }
        return $this->mc;
    }

    /**
     * @param $message
     * @param $status
     * @return string
     */
    function Message($message, $status) {
        $message = '<div class="message ' . $status . '">' . $message . '</div>';
        return $message;
    }

    /**
     * @return bool
     */
    public function getPageSubTitle() {
        if (isset($_GET['title'])) {
            return $_GET['title'];
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getForm() {
        switch (Session::get('type')) {
            case 'list':
                $form = self::getListForm();
                break;
            case 'campaign':
                $form = self::getCampaignForm();
                break;
            default:
                break;
        }
        return $form;
    }

    /* -----------------------------------------
     * Campaign
    ------------------------------------------*/

    /**
     * @return string
     */
    public function campaigns() {
        self::Connect();
        $lists = $this->mc->campaigns->getList();
        try {
            $lists = $this->mc->campaigns->getList();
        } catch (Mailchimp_Error $e) {
            if ($e->getMessage()) {
                $this->setFlash($e->getMessage(), 'danger');
            } else {
                $this->setFlash('An unknown error occurred', 'danger');
            }
        }
        return Convert::array2json($lists);
    }

    /**
     * @return HTMLText
     */
    public function viewCampaign() {
        if (Session::get('CreateCampaign') == 1) {
            Session::set('CreateCampaign', 0);
        }
        $params = $this->getURLParams();
        Session::set('campaignID', $params["ID"]);
        Session::set('type', 'campaign');
        return $this->renderWith('MailChimpAction');
    }

    /*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/

    /**
     * @return Form
     */
    public function getCampaignForm() {

        $params = $this->getURLParams();

        // Connect
        //-------------------------

        $config = SiteConfig::current_site_config();
        if(!$config->MailChimpAPI)return;
        try {
            $this->mc = new Mailchimp($config->MailChimpAPI);
        } catch (Mailchimp_Error $e) {
            $this->error($e);
        }

        $lists = $this->mc->lists->getList();

        $listData = array();
        $listData[$lists['data'][0]["id"]] = $lists['data'][0]["name"];
        $listName = '';
        $title = '';
        $subject = '';
        $defaultFromEmailA = $lists['data'][0]['default_from_email'];
        $fromEmailA = $lists['data'][0]['default_from_email'];
        $fromEmailB = '';
        $defaultFromNameA = $lists['data'][0]['default_from_name'];
        $fromNameA = $lists['data'][0]['default_from_name'];
        $fromNameB = '';
        $google = '';
        $list = '';
        $html = '';
        $plainText = '';
        $status = '';
        $archive_url = '';
        // If we are viewing an existing campaign form
        if (strcmp(Session::get('campaignID'), '0') != 0) {
            // Get the campaign content
            $campaignContent = $this->mc->campaigns->content(Session::get('campaignID'));
            // Set the content vars
            $html = $campaignContent["html"];
            $plainText = $campaignContent["text"];
            // Get the campaign data
            $campaign = $this->mc->campaigns->getList(array(
                'campaign_id' => Session::get('campaignID')
            ));
            // Set the data vars
            $loadedListId = $campaign['data'][0]['list_id'];
            $loadedList = $this->mc->lists->getList(array('list_id' => $loadedListId));
            $listName = $loadedList['data'][0]['name'];
            $title = $campaign['data'][0]['title'];
            $fromEmailA = $campaign['data'][0]['from_email'];
            $fromNameA = $campaign['data'][0]['from_name'];
            $subject = $campaign['data'][0]['subject'];
            $google = $campaign['data'][0]['analytics_tag'];
            //TODO: Status being weird
            $status = $campaign['data'][0]['status'];
            $archive_url = $campaign['data'][0]['archive_url'];
            $segments = $campaign['data'][0]['segment_text'];
            $segment_opts = $campaign['data'][0]['segment_opts'];
            // Format the send time, accounting for GMT
            $send_time = date("D d F Y h:i a", strtotime("+12 hours", strtotime($campaign['data'][0]['send_time'])));
        }

        // Tabs
        //-------------------------

        $fields = new FieldList();
        $tabSet = new TabSet('Campaign', 'Campaign');

        // Settings
        //-------------------------

        $settingsTab = new Tab('Settings', 'Settings');

        /**
         * Check for errors
         */
        if (Session::get('CampaignError') != 0) {
            $settingsTab->push(new LiteralField('Error: ', '<p>' . Session::get('CampaignError') . '</p>'));
        }

        /**
         * Determine campaign status
         */
        if (strcmp(Session::get('campaignID'), '0') != 0) {
            $readonly = new ReadonlyField('Status', 'Status');
            $readonly->setValue($status);
            switch ($status) {
                case 'sent':
                    $readonly->addExtraClass('field-sent');
                    break;
                case 'save':
                    $readonly->addExtraClass('field-save');
                    break;
                case 'sending':
                case 'schedule':
                case 'paused':
                    $readonly->addExtraClass('field-sending');
                    break;
                default:
                    break;
            }
            $settingsTab->push($readonly);
        }
        $settingsTab->push(new TextField('Title', 'Title', $title));
        $settingsTab->push(new TextField('Subject', 'Subject', $subject));

        /**
         Get the list groups to send the campaign to. Only for new campaigns.
        */
        switch ($status) {
            case 'sent':
            case 'sending':
            case 'schedule':
            case 'paused':
            case 'save':

                // Set the Groups send text
                switch ($status) {
                    case 'sent':
                        $sendStatus = 'Sent';
                        break;
                    default:
                        $sendStatus = 'Sending';
                        break;
                }
                // Set the HTML text for the LiteralField groups block
                $listTextDiv = '<div class="field text" id="GroupsBlock">
						<label for="" class="left">' . $sendStatus . ' to List</label>
						<div class="middleColumn">
							<ul class="optionset">
								<li><label for="" class="text">' . $listName . '</label></li>
							</ul>
						</div>
					</div>';
                // Add a literal field in for sending to groups
                $settingsTab->push(new LiteralField('Sending to List', $listTextDiv));
//                $settingsTab->push($test = new ReadonlyField('', $listName));
//                $test->setTitle($sendStatus);
                // If there are segment options
                if ($segment_opts) {
                    //$settingsTab->push(new HiddenField('SegmentOptions', '', $segment_opts));
                    // Get the list interest groups from MailChimp for the loaded campaign's list ID
                    $interestGroups = $this->mc->lists->interestGroupings($loadedListId);
                    foreach ($interestGroups as $interestGroupsData) {
                        $groupsForList = array();
                        foreach ($interestGroupsData['groups'] as $interestGroup) {
                            foreach ($segment_opts['conditions'] as $condition) {
                                foreach ($condition['value'] as $bit) {
                                    if ($interestGroup['bit'] == $bit) {
                                        $groupsForList[] = $interestGroup['name'];
                                    }
                                }
                            }
                        }
                        // Set the HTML text for the LiteralField groups block
                        $groupsTextDiv = '<div class="field text" id="GroupsBlock">
							<label for="" class="left">' . $sendStatus . ' to Groups</label>
							<div class="middleColumn">
								<ul class="optionset">';
                        // Loop through the aGroupsForList array
                        foreach ($groupsForList as $listGroup) {
                            $groupsTextDiv .= '<li><label for="" class="text">' . $listGroup . '</label></li>';
                        }
                        $groupsTextDiv .= '</ul>
							</div>
						</div>';
                        // Add a literal field in for sending to groups
                        $settingsTab->push(new LiteralField('Sending to groups', $groupsTextDiv));
                    }
                } else {
                    $settingsTab->push($sendingToGroupsField = new ReadonlyField('', 'Sending to Groups'));
                    $sendingToGroupsField->setValue('All Members');
                }

                /**
                 * Show the sent time
                */
                switch ($status) {
                    case 'sent':
                        $settingsTab->push($sentTimeField = new ReadonlyField('', 'Sent'));
                        $sentTimeField->setValue($send_time);
                        break;
                    case 'schedule':
                        $settingsTab->push($sendTimeField = new ReadonlyField('', 'Scheduled'));
                        $sendTimeField->setValue($send_time);
                        break;
                    default:
                        break;
                }

                /**
                 * Set the FromEmail and FromName values
                 */
                $fromEmail = $fromEmailA;
                $fromName = $fromNameA;
                break;
            /**
             * New campaigns
             */
            default:
                /**
                 * Loop though each list and set the radio buttons
                 */
                foreach ($lists['data'] as $list) {
                    $listData[$list['id']] = $list['name'];
                    $fromEmailA = $list['default_from_email'];
                    $fromNameA = $list['default_from_name'];
                    // Check for multi-list management
                    switch ($this->bMultiSite) {
                        case true:
                            // Add the radio buttons for the lists into the fieldset
                            $settingsTab->push(new OptionsetField('List', 'Choose a List', $listData, $lists['data'][0]['id']));
                            // Set the hidden default from email address, used for jQuery population
                            $settingsTab->push(new HiddenField($list['id'] . 'FromEmail', '', $fromEmailA));
                            // Set the hidden default from name, used for jQuery population
                            $settingsTab->push(new HiddenField($list['id'] . 'FromName', '', $fromNameA));
                            break;
                        case false:
                        default:
                            // Set the list ID
                            $settingsTab->push(new HiddenField('List', '', $lists['data'][0]['id']));
                            break;
                    }
                }
                /**
                 * Loop though each list and set the checkboxes
                 */
                foreach ($lists['data'] as $list) {
                    $listGroups = $this->mc->lists->InterestGroupings($list['id']);
                    if ($listGroups) {
                        foreach ($listGroups as $listGroupsData) {
                            $groupsForList = array();
                            foreach ($listGroupsData['groups'] as $group) {
                                $groupsForList[] = $group['name'];
                            }
                            $settingsTab->push(
                                new FieldGroup(
                                    new CheckboxSetField('Groups' . $list['id'], $listGroupsData['name'], $groupsForList, -1)
                                )
                            );
                        }
                    }
                }
                $fromEmail = $defaultFromEmailA;
                $fromName = $defaultFromNameA;
                break;
        }

        /**
         * Add the FromEmail and FromName fields
        */
        $settingsTab->push(new TextField('FromEmailA', 'From Email', $fromEmail));
        $settingsTab->push(new TextField('FromNameA', 'From Name', $fromName));

        // Content
        //-------------------------

        $contentTab = new Tab('Content', 'Content');

        /**
         * Get all newsletter pages
         */
        $newsletters = NewsletterPage::get();
        if ($newsletters) {
            $newslettersList = array();
            foreach ($newsletters as $newsletter) {
                $newsletterLink = Director::absoluteURL($newsletter->Link());
                $newslettersList[$newsletterLink] = $newsletter->Title;
            }
            $contentTab->push($newsletterDropdown = new DropdownField('URLContent', 'Newsletters', array('' => 'Please select a list') + $newslettersList));
        } else {
            $contentTab->push(new HiddenField('URLContent', false));
            $contentTab->push(new LiteralField('', 'No Newsletters found. You need to create a Newsletter Page in the CMS.'));
        }
        if ($archive_url != '') {
            $contentTab->push(new LiteralField('CurrentURLContent', '<a class="cms-link" href="' . $archive_url . '" target="_blank">View current Newsletter</a>'));
        }

        // Schedule
        //-------------------------

        $scheduleTab = new Tab('Schedule', 'Schedule');

//        $scheduleTab = new Tab("Schedule", "Schedule");
//        switch ($status) {
//            case 'schedule':
//                $schedTextDiv = '<div class="field text" id="GroupsBlock">';
//                $schedTextDiv .= '<label for="" class="left">Scheduled: ' . $send_time . '</label>';
//                $schedTextDiv .= '</div>';
//                // Add a literal field in for one
//                $scheduleTab->push(new LiteralField('Scheduled', $schedTextDiv));
//                $scheduleTab->push(new CheckboxField("UnSchedule", "Unschedule campaign"));
//                break;
//            default:
//                // Add title field
//                $titleField = '<div class="field text" id="GroupsBlock">
//					<label for="" class="left">Send campaign on this date</label>
//				</div>';
//                $scheduleTab->push(new LiteralField('Label', $titleField));
//                // Create field group
//                $fieldGroup = new FieldGroup();
//                // Create custom date field
//                $dateField = new CustomDateField("ScheduleDate", "");
//                // Set date field options
//                $dateField->getDateField()->setConfig('showcalendar', true);
//                $dateField->getDateField()->setConfig('dateformat', 'dd MMM YYYY');
//                // Add the fields to the field group
//                $fieldGroup->push($dateField);
//                // Add hour field
//                $hour = new DropdownField('ScheduleTime_Hours', '', self::makeTimeArray('Hour', 1, 1, 12, '%02d'));
//                $hour->addExtraClass('short');
//                $fieldGroup->push($hour);
//                // Add minute field
//                $minute = new DropdownField('ScheduleTime_Minutes', '&nbsp;&nbsp;', self::makeTimeArray('Min', 5, 5, 59, '%02d', '01'));
//                $minute->addExtraClass('short');
//                $fieldGroup->push($minute);
//                // Add meridiem field
//                $meridiem = new DropdownField('ScheduleTime_Meridiem', '&nbsp;&nbsp;', array('am'=>'AM', 'pm'=>'PM'));
//                $meridiem->addExtraClass('short');
//                $fieldGroup->push($meridiem);
//                // Add the field group to the tab
//                $scheduleTab->push($fieldGroup);
//                break;
//        }

        // Analytics
        //-------------------------

        $analyticsTab = new Tab('Analytics', 'Analytics');
        $analyticsTab->push(new TextField('GoogleAnalytics', 'Google Analytics Key', $google));

        // Test Email
        //-------------------------

        $testEmailTab = new Tab('TestEmail', 'Test Email');

        if (strcmp(Session::get('campaignID'), '0') != 0) {
            $testEmailTab->push($testEmailAddress = new TextField('TestEmailAddress', 'Email Address'));
            $testEmailAddress->setRightTitle('Can be a comma separated list');
        }

        // Stats
        //-------------------------

        $statsTab = new Tab('Stats', 'Stats');

//        if ($status == 'sent') {
//            $statsTab = new Tab("Stats", "Stats");
//            $campaignStatsJS = "";
//            $stats = $this->mc->campaignStats(Session::get("campaignID"));
//            $clicks = $this->mc->campaignClickStats(Session::get("campaignID"));
//            $geo = $this->mc->campaignGeoOpens(Session::get("campaignID"));
//            if (!$this->mc->errorCode) {
//                $opens = $stats['unique_opens'];
//                $left = $stats['emails_sent'] - $opens;
//                $hBounces = $stats['hard_bounces'];
//                $sBounces = $stats['soft_bounces'];
//                // Start JavaScript
//                $campaignStatsJS .= <<<JS
//					function drawCharts() {
//						campaignOpenStats();
//						campaignClicks();
//						campaignGeo();
//					}
//					function campaignOpenStats() {
//					  var data = new google.visualization.DataTable();
//					  data.addColumn('string', 'Title');
//					  data.addColumn('number', 'Campaigns');
//					  data.addRows(5);
//					  data.setValue(0, 0, 'Opened');
//					  data.setValue(0, 1, $opens);
//					  data.setValue(1, 0, 'Left Behind');
//					  data.setValue(1, 1, $left);
//					  data.setValue(2, 0, 'Hard Bounces');
//					  data.setValue(2, 1, $hBounces);
//					  data.setValue(3, 0, 'Soft Bounces');
//					  data.setValue(3, 1, $sBounces);
//
//					  // Create and draw the visualization.
//					  new google.visualization.PieChart(document.getElementById('Campaign_Opens')).
//					      draw(data, {width: 400, height: 240, is3D: true, title:"Basic Statistics"});
//					}
//JS
//                ;
//                // End JavaScript
//                $clickRows = "[";
//                foreach ($clicks as $url => $data) {
//                    $clickRows .= "['" . $url . "', " . $data['clicks'] . ", " . $data['unique'] . "],\n";
//                }
//
//                $clickRows = substr($clickRows, 0, -1);
//                $clickRows .= "]";
//
//                //echo $clickRows;
//                //die();
//
//                // Start JavaScript
//                $campaignStatsJS .= <<<JS
//					function campaignClicks() {
//				  		var data = new google.visualization.DataTable();
//					  	data.addColumn('string', 'URL');
//						data.addColumn('number', 'Clicks');
//						data.addColumn('number', 'Unique');
//						data.addRows($clickRows);
//
//						// Create and draw the visualization.
//						new google.visualization.LineChart(document.getElementById('Clicks')).
//						draw(data, {width: 400, height: 240, is3D: true, title:"Clicks"});
//					}
//JS
//                ;
//                // End JavaScript
//                $geoJS = "[";
//                if (is_array($geo)) {
//                    foreach ($geo as $geoCont) {
//                        $geoJS .= "['" . $geoCont['name'] . "', " . $geoCont['opens'] . "],";
//                    }
//                }
//
//                $geoJS = substr($geoJS, 0, -1);
//                $geoJS .= "]";
//                // Start JavaScript
//                $campaignStatsJS .= <<<JS
//					function campaignGeo() {
//				  		var data = new google.visualization.DataTable();
//					  	data.addColumn('string', 'Country');
//						data.addColumn('number', 'Opens');
//						data.addRows($geoJS);
//
//						// Create and draw the visualization.
//						var geoMap = new google.visualization.GeoMap(document.getElementById('GEOCountry'));
//						geoMap.draw(data, {
//							width: 400,
//							height: 250,
//							title:"Clicks",
//							dataMode: 'regions'
//						});
//
//						google.visualization.events.addListener(geoMap, 'regionClick', function(obj) {
//							jQuery.ajax({
//								url: 'admin/mailchimp/regiondata',
//								dataType: 'json',
//								data: 'region=' + obj.region,
//								success: function(data) {
//									if (data.success == 1) {
//
//								  		var dataR = new google.visualization.DataTable();
//									  	dataR.addColumn('string', 'Country');
//										dataR.addColumn('number', 'Opens');
//										dataR.addRows(data.data);
//										region = new google.visualization.GeoMap(document.getElementById('GEORegion'));
//										region.draw(dataR, {
//											width: 400,
//											height: 250,
//											title:"Clicks",
//											region: obj.region,
//											dataMode: 'markers'
//										});
//
//									}else{
//										alert("Error while retrieving data.");
//									}
//								}
//							});
//						});
//
//					}
//JS
//                ;
//                // End JavaScript
//            }
//
//            if ($this->mc->errorCode) {
//                $statsTab->push(new LiteralField("ErrorStats", "<p>Sorry! I am unable to retrieve statistics for the campaign at this time. " . $this->mc->errorMessage . "</p>"));
//            } else {
//                Requirements::javascript("http://www.google.com/jsapi");
//                // Start JavaScript
//                Requirements::customScript(<<<JS
//					google.load('visualization', '1', {'packages':['piechart', 'linechart', 'geomap']});
//					$campaignStatsJS
//					google.setOnLoadCallback(drawCharts);
//JS
//                );
//                // End JavaScript
//                $statsTab->push(new LiteralField('OpensCharts', '<div class="statHolder"><h1>Campaign Statistics</h1><div id="Campaign_Opens" class="box"></div><div id="Clicks" class="box"></div><div class="box"><div id="GEOCountry"></div><p>Opens over regions. Click to retrieve more infomation.</p></div><div id="GEORegion" class="box"></div></div>'));
//
//            }
//        }

        // Tabs
        //-------------------------

        /**
         * Choose which tabs to display depending on the campaign status
        */
        switch ($status) {
            case 'sent':
                $tabSet->push($settingsTab);
                $tabSet->push($statsTab);
                break;
            case 'sending':
            case 'paused':
            $tabSet->push($settingsTab);
                break;
            case 'schedule':
                $tabSet->push($settingsTab);
                $tabSet->push($scheduleTab);
                break;
            case 'save':
                $tabSet->push($settingsTab);
                $tabSet->push($contentTab);
                $tabSet->push($scheduleTab);
                $tabSet->push($analyticsTab);
                $tabSet->push($testEmailTab);
                break;
            default:
                $tabSet->push($settingsTab);
                $tabSet->push($contentTab);
                break;
        }

        // Actions
        //-------------------------

        $action = 'updateCampaign';
        $buttonText = 'Update Campaign';
        if (strcmp(Session::get('campaignID'), '0') == 0) {
            $action = 'createCampaign';
            $buttonText = 'Save Campaign';
        }

        /**
         * Create the required action buttons (fifth param is extra class if required: alert(yellow), create(green), or delete(red))
        */
        $editButton = new FormAction($action, $buttonText);
        $testButton = new FormAction('sendCampaignTest', 'Send Test Campaign');
        $sendButton = new FormAction('sendNewsletter', 'Send Campaign', '', '', 'alert');
        $deleteButton = new FormAction('deleteCampaign', 'Delete Campaign', '', '', 'delete');

        /**
         * Choose the action buttons to display depending on the campaign status
        */
        switch ($status) {
            case 'sent':
            case 's':
                $actionButtons = array($deleteButton);
                break;
            case 'save':
                $actionButtons = array($editButton, $testButton, $sendButton, $deleteButton);
                break;
            case 'sending':
                $actionButtons = array();
                break;
            case 'schedule':
                $actionButtons = array($editButton, $deleteButton);
                break;
            case 'paused':
                $actionButtons = array($deleteButton);
                break;
            default:
                $actionButtons = array($editButton);
                break;
        }
        $actions = new FieldList($actionButtons);
        $fields->push($tabSet);
        return new Form($this, 'getCampaignForm', $fields, $actions);
    }

    /*----------------------------------------------------------------------------------------------------------------------------------------------------------------*/

    /**
     * @param $data
     * @param $form
     * @return mixed
     */
    public function createCampaign($data, $form) {
        Session::set('CreateCampaign', 1);
        Session::set('CampaignError', 0);
        $config = SiteConfig::current_site_config();
        try {
            $this->mc = new Mailchimp($config->MailChimpAPI);
        } catch (Mailchimp_Error $e) {
            $this->error($e);
        }

        $type = 'regular';
        $listId = $data['List'];
        $groupsDivId = 'Groups' . $listId;
        if (@$data[$groupsDivId]) {
            $conditions = array();
            $groups = $this->mc->lists->InterestGroupings($listId);
            if ($groups) {
                foreach ($groups as $group) {
                    $groupId = $group['id'];
                    $groupNames = '';
                    foreach ($data[$groupsDivId] as $key) {
                        $groupNames .= $group['groups'][$key]['name'] . ',';
                    }
                    $groupNames = substr($groupNames, 0 , -1);
                    $conditions[] = array(
                        'field' => 'interests-' . $groupId,
                        'op' => 'all',
                        'value' => $groupNames
                    );
                }
            }
        }
        $opts = array(
            'list_id' => $listId,
            'subject' => $data['Subject'],
            'from_email' => $data['FromEmailA'],
            'from_name' => str_replace(',', ' - ', str_replace(', ', ',', $data['FromNameA'])),
            'tracking' => array(
                'opens' => true,
                'html_clicks' => true,
                'text_clicks' => false
            ),
            'authenticate' => true,
            'analytics' => array(
                'google' => @$data['GoogleAnalytics']
            ),
            'title' => $data['Title'],
            'generate_text' => false,
            'auto_footer' => false
        );
        switch (empty($conditions)) {
            case true:
            default:
                // Set the segment options to NULL
                $segment_opts = null;
                break;
            case false:
                // Set the segment options array
                $segment_opts = array(
                    'match' => 'any',
                    'conditions' => $conditions
                );
                break;
        }
        // Set the content array
        // TODO: Add URL
        $content = array(
            'text' => $data['URLContent'],
            'url' => 'http://google.com'
        );
        // If there are segments
        if (!empty($segment_opts)) {
            // Test for existing email addresses
            $numMembers = $this->mc->campaigns->segmentTest($listId, $segment_opts);
            // If there are none found
            if (!$numMembers) {
                // Set the feedback message
                $this->Feedback = $this->Message('Cannot create campaign. No members matched your group selection', 'bad');
                // Return the page
                return $this->renderWith("MailChimpAction");
            }
        }
        /**
         * Create the campaign
        */
        try{
            $campaignId = $this->mc->campaigns->Create($type, $opts, $content, $segment_opts);
            //$campaignId = $this->mc->campaigns->Create($type, $opts, array('text' => 'Derp'), null);
        } catch(Mailchimp_Error $e){
            exit($e->getMessage());
        }

        // Set the session campaign ID to the returned ID
        Session::set('campaignID', $campaignId['id']);
        // Set the feedback message, dependent on whether there are segment_opts or not
        if (!empty($segment_opts)) {
            $this->Feedback = $this->Message('Campaign created. Your group selection matched', 'good');
        } else {
            $this->Feedback = $this->Message('Campaign created. Sending to ALL members', 'good');
        }
        // Add the jQuery script to reload the campaigns
        //$this->reloadCampaigns();
        // Return the page
        return $this->renderWith('MailChimpAction');
    }

    /**
     * @return HTMLText
     */
    public function deleteCampaign() {
        self::Connect();
        try{
        $this->mc->campaigns->Delete(Session::get('campaignID'));
        } catch(Mailchimp_Error $e){
            $e->getCode().': '.$e->getMessage();
        }
        // Set the session campaign ID to 0 (false)
        Session::set('campaignID', 0);
        $this->Feedback = $this->Message('Campaign deleted', 'good');
        //$this->reloadCampaigns();
        return $this->renderWith('MailChimpAction');
    }

    /* -----------------------------------------
     * List
    ------------------------------------------*/

    /**
     * @return string
     */
    public function lists() {
        self::Connect();
        $lists = $this->mc->lists->getList();
        try {
            $lists = $this->mc->lists->getList();
        } catch (Mailchimp_Error $e) {
            if ($e->getMessage()) {
                $this->setFlash($e->getMessage(), 'danger');
            } else {
                $this->setFlash('An unknown error occurred', 'danger');
            }
        }
        return Convert::array2json($lists);
    }

    /**
     * @return HTMLText
     */
    public function viewList() {
        $params = $this->getURLParams();
        Session::set('listID', $params['ID']);
        Session::set('type', 'list');
        return $this->renderWith('MailChimpAction');
    }

    /**
     * @return Form
     */
    public function getListForm() {

        // Actions
        //-------------------------

        $actions = new FieldList(
            $actionSaveGroup = new FormAction('saveGroup', 'Save Group')
        );
        $actionSaveGroup->setAttribute('role', 'button');

        // Connect
        //-------------------------

        self::Connect();

        $tabSet = new TabSet('List', 'List');

        // Add Groups
        //-------------------------

        $addGroupsTab = new Tab('AddGroups', 'Add Groups');
        $tabSet->push($addGroupsTab);
        $addGroupsTab->push(new HeaderField('AddGroups', 'Add Groups'));
        $addGroupsTab->push(new TextField('GroupName', 'Group Name'));

        //Check if this list has a group, if not only display the create groups tab
        try{
            $this->mc->lists->InterestGroupings(Session::get('listID'));
        }catch(Exception $e){
            return new Form($this, 'getListForm', new FieldList(array(
                $tabSet
            )), $actions);
        }

        // Groups
        //-------------------------

        $groupsTab = new Tab('Groups', 'Groups');
        $tabSet->push($groupsTab);
        $groupsTab->push(new HeaderField('Groups'));
        $listGroups = $this->mc->lists->InterestGroupings(Session::get('listID'));
        $groupsList = new ArrayList();
        foreach ($listGroups as $record) {
            foreach ($record['groups'] as $info) {
                $groupsList->push(new DataObject(
                    array(
                        'GroupName' => $info['name']
                    )
                ));
            }
        }
        $gridFieldConfig = new GridFieldConfig();
        $gridFieldConfig->addComponent(
            $dataColumns = new GridFieldDataColumns()
        );
        $dataColumns->setDisplayFields(array(
            'GroupName' => 'Group Name'
        ));
        $gridField = new GridField('GroupList', 'GroupList', $groupsList, $gridFieldConfig);
        $groupsTab->push($gridField);

        // Subscribers
        //-------------------------

        $listMembers = $this->mc->lists->members(Session::get('listID'));
        $subscribersTab = new Tab('Subscribers', 'Subscribers');
        $tabSet->push($subscribersTab);
        $subscribersTab->push(new HeaderField('Subscribers'));
        $subscriberList = new ArrayList();
        foreach ($listMembers['data'] as $member) {
            $subscriberList->push(new DataObject(
                array(
                    'FirstName' => $member['merges']['FNAME'],
                    'LastName' => $member['merges']['LNAME'],
                    'Email' => $member['email']
                )
            ));
        }
        $gridFieldConfig = new GridFieldConfig();
        $gridFieldConfig->addComponent(
            $dataColumns = new GridFieldDataColumns()
        );
        $dataColumns->setDisplayFields(array(
            'FirstName' => 'FirstName',
            'LastName' => 'LastName',
            'Email' => 'Email'
        ));
        $gridField = new GridField('SubscribersList', 'SubscribersList', $subscriberList, $gridFieldConfig);
        $subscribersTab->push($gridField);

        // Add Subscribers
        //-------------------------

        $addSubscribersTab = new Tab('AddSubscribers', 'Add Subscribers');
        $tabSet->push($addSubscribersTab);
        $addSubscribersTab->push(new HeaderField('AddSubscribers', 'Add Subscribers'));
        $addSubscribersTab->push(new TextField('Email', 'Email'));
        $addSubscribersTab->push(new TextField('FirstName', 'First Name'));
        $addSubscribersTab->push(new TextField('LastName', 'Last Name'));
        $listGroups = $this->mc->lists->InterestGroupings(Session::get('listID'));
        if ($listGroups) {
            foreach ($listGroups as $listGroupsData) {
                $groupsForList = array();
                foreach ($listGroupsData['groups'] as $group) {
                    $groupsForList[] = $group['name'];
                }
                $addSubscribersTab->push(new CheckboxSetField('InterestGroups', $listGroupsData['name'], $groupsForList, -1));
            }
        }

        // Create Form
        //-------------------------

        $actions->push(
            $actionSaveSubscriber = new FormAction('saveList', 'Save Subsciber')
        );
        $actionSaveSubscriber->setAttribute('role', 'button');

        return new Form($this, 'getListForm', new FieldList(array(
            $tabSet
        )), $actions);
    }

    /**
     * @param $data
     * @param $form
     * @return HTMLText
     */
    public function saveList($data, $form) {
        self::Connect();
        $groups = $this->mc->lists->InterestGroupings(Session::get('listID'));
        if ($groups) {
            foreach ($groups as $group) {
                $groupID = $group['id'];
                $groupNames = '';
                if (isset($data['InterestGroups'])) {
                    foreach ($data['InterestGroups'] as $key => $value) {
                        $groupNames .= $group['groups'][$key]['name'] . ',';
                    }
                    $groupNames = substr($groupNames, 0, -1);
                }
            }
        }
        $merge_vars = array(
            'FNAME' => $data['FirstName'],
            'LNAME' => $data['LastName'],
            'GROUPINGS' => array(
                array(
                    'id' => $groupID,
                    'groups' => $groupNames
                )
            )
        );
        try {
            $this->mc->lists->Subscribe(Session::get('listID'), array('email' => $data['Email']), $merge_vars);
        } catch (Mailchimp_Error $e) {
            if($e->getMessage()){
                $this->Feedback = $this->Message($e->getMessage(), 'bad');
            }
            return $this->renderWith('MailChimpAction');
        }
        $this->Feedback = $this->Message('Member ' . $data['Email'] . ' subscribed', 'good');
        return $this->renderWith('MailChimpAction');
    }

    /**
     * @param $data
     * @param $form
     * @return HTMLText
     */
    function saveGroup($data, $form) {
        self::Connect();
        try {
            $this->mc->lists->InterestGroupAdd(Session::get('listID'), $data['GroupName']);
        } catch (Mailchimp_Error $e) {
            if($e->getMessage()){
                $this->Feedback = $this->Message($e->getMessage(), 'bad');
            }
            return $this->renderWith('MailChimpAction');
        }
        $this->Feedback = $this->Message('Group: '.$data['GroupName'].' added', 'good');
        return $this->renderWith('MailChimpAction');
    }

    /* -----------------------------------------
     * Settings
    ------------------------------------------*/

    /**
     * @param null $id
     * @param null $fields
     * @return Form
     */
    public function getAPIForm($id = null, $fields = null) {
        $fields = new FieldList(
            TextField::create('MailChimpAPI', 'MailChimp API', SiteConfig::current_site_config()->MailChimpAPI)
        );
        $actions = new FieldList(
            FormAction::create('doAPIFormSave')->setTitle('Save')->addExtraClass('ss-ui-action-constructive')
        );
        return new Form($this, 'getAPIForm', $fields, $actions);
    }

    /**
     * @param $data
     * @param Form $form
     */
    public function doAPIFormSave($data, Form $form){
        if($api = $data['MailChimpAPI']){
            if($siteconfig = SiteConfig::current_site_config()){
                $siteconfig->MailChimpAPI = $this->mc;
                $siteconfig->write();
            }else{
                $form->AddErrorMessage('SiteConfig', 'No current SiteConfig', 'validation');
            }
        }else{
            $form->AddErrorMessage('SiteConfig', 'Please enter an API key', 'validation');
        }
        $this->redirectBack();
    }

    /**
     * @return bool
     */
    public function hasAPI() {
        $siteConfig = SiteConfig::current_site_config();
        if ($siteConfig) {
            if($siteConfig->MailChimpAPI != "")
                return true;
        }
        return false;
    }

}