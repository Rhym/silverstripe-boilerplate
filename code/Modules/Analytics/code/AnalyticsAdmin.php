<?php

require_once Director::baseFolder().'/'.ANALYTICS_MODULE_DIR.'/thirdparty/gapi.class.php';

class AnalyticsAdmin extends LeftAndMain {

    private static $url_segment = 'analytics';
    private static $url_priority = 100;
    private static $menu_title = 'Analytics';

    protected static $gapi_email = 'drawrdesign@gmail.com';
    protected static $gapi_password = 'Drawr8001677';
    protected static $gapi_profile = '43338263';
    protected static $cache = true;
    protected $gapi;

    public function init() {
        parent::init();
        Requirements::css(ANALYTICS_MODULE_DIR.'/css/analytics.min.css');
        Requirements::javascript(ANALYTICS_MODULE_DIR.'/javascript/jquery.flot.min.js');
        Requirements::javascript(ANALYTICS_MODULE_DIR.'/javascript/jquery.flot.pie.min.js');
        Requirements::javascript(ANALYTICS_MODULE_DIR.'/javascript/analytics.js');
    }

    /**
     * @param $seconds
     * @return string
     */
    public static function seconds_to_minutes($seconds) {
        $minResult = floor($seconds/60);
        if($minResult < 10){$minResult = 0 . $minResult;}
        $secResult = ($seconds/60 - $minResult)*60;
        if($secResult < 10){$secResult = 0 . round($secResult);}
        else { $secResult = round($secResult); }
        return $minResult.":".$secResult;
    }

    /**
     * @return int
     */
    public function getStartDateStamp() {
        switch($this->DateRange) {
            case "day":
                return time();
            case "week":
                return strtotime("-7 days");
            case "month":
                return strtotime("-30 days");
            case "year":
                return strtotime("-1 year");
            default:
                return strtotime("-30 days");

        }
    }

    /**
     * @param $email
     * @param $password
     * @param $profile
     */
    public static function set_account($email, $password, $profile) {
        self::$gapi_email = $email;
        self::$gapi_password = $password;
        self::$gapi_profile = $profile;
    }

    /**
     * @return gapi
     */
    public function api() {
        if(!$this->gapi) {
            try {
                $this->gapi = new gapi(self::$gapi_email, self::$gapi_password);
            }
            catch(Exception $e) {
                return $this->gapi;
            }
        }
        return $this->gapi;
    }

    /**
     * @return bool
     */
    public function IsConnected() {
        return $this->api() ? true : false;
    }

    /**
     * @return bool
     */
    public function IsConfigured() {
        return self::$gapi_email && self::$gapi_password && self::$gapi_profile;
    }

    /**
     * @return bool
     */
    public function isValid() {
        return $this->IsConfigured() && $this->IsConnected();
    }

    public function Browsers() {
        try {
            $this->api()->requestReportData(
                self::$gapi_profile,
                array('date'),
                array('pageviews'),
                'date',
                $this->getPath() ? "pagePath == {$this->getPath()}" : null,
                date('Y-m-d',$this->getStartDateStamp())
            );
        }
        catch(Exception $e) {
            user_error($e);
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function PageResults() {

        // If using cache
        if(self::$cache) {
            $cache_id = md5(serialize(func_get_args()));
            // check if the cache item exists.
            $temp_folder = '/tmp/ga/';
            if (!is_dir($temp_folder)) {
                mkdir($temp_folder);
            }
            $filename = $temp_folder . $cache_id;
            if (is_file($filename)) { // if cache entry exists
                if (filemtime($filename) > (time() - 172800)) { // check if it's older than 2 days
                    return unserialize(file_get_contents($filename)); // grab the cached content.
                }
            }
        }

        // Check if the api and biz are all geezy
        if(!$this->isValid()) return false;

        try {
            $this->api()->requestReportData(
                self::$gapi_profile,
                array(
                    'pagePath'
                ),
                array(
                    'sessions',
                    'users',
                    'pageviews',
                    'pageviewsPerSession',
                    'avgSessionDuration',
                    'bounceRate',
                    'percentNewSessions'
                ),
                null,
                null,
                date('Y-m-d',$this->getStartDateStamp())
            );
        }
        catch(Exception $e) {
            user_error($e);
            return false;
        }
        $arrayList = ArrayList::create(array());
        $results = $this->api()->getMetrics();
        if($results) {
            $arrayList->push(ArrayData::create(array(
                'Sessions' => number_format($results['sessions']),
                'Users' => number_format($results['users']),
                'PageViews' => number_format($results['pageviews']),
                'PageViewsPerSession' => round($results['pageviewsPerSession'], 2),
                'AverageSessionDuration' => self::seconds_to_minutes($results['avgSessionDuration']),
                'BounceRate' => round($results['bounceRate'], 2)."%",
                'PercentNewSessions' => round($results['percentNewSessions'], 2)."%"
            )));
        }
        if(self::$cache) {
            file_put_contents($filename, serialize($arrayList));
        }

        return $arrayList;
    }

    /**
     * @return ArrayList
     */
    public function SEOSnippet() {
        $meta = get_meta_tags(Director::absoluteBaseURL(), false);
        $metaDescription = '';
        $siteConfig = SiteConfig::current_site_config();
        $title = $siteConfig->Title;
        if(isset($meta['description'])){
            $metaDescription = $meta['description'];
        }
        if($tagline = $siteConfig->Tagline) $title.=' - '.$tagline;
        $arrayList = new ArrayList();
        $arrayList->push(new ArrayData(array(
            'Title' => $title,
            'URL' => Director::absoluteBaseURL(),
            'Description' => $metaDescription,
        )));
        return $arrayList;
    }

    public function Actions() {
        $siteConfig = SiteConfig::current_site_config();
        $arrayList = new ArrayList();
        // Title
        if(!$siteConfig->Title) {
            $arrayList->push(new ArrayData(array(
                'Type' => 'error',
                'Message' => 'You have not given your website a title. This can be set in: <a href="'.Director::absoluteBaseURL().'admin/settings'.'">Settings</a>'
            )));
        }
        // Tagline
        if(!$siteConfig->Tagline) {
            $arrayList->push(new ArrayData(array(
                'Type' => 'warning',
                'Message' => 'You have not given your website a tagline. This can be set in: <a href="'.Director::absoluteBaseURL().'admin/settings'.'">Settings</a>'
            )));
        }
        // Google analytics
        if(!$siteConfig->TrackingCode) {
            $arrayList->push(new ArrayData(array(
                'Type' => 'warning',
                'Message' => 'Google analytics has been added to this site. This can be set under: <a href="'.Director::absoluteBaseURL().'admin/settings'.'">Settings > Analytics</a>'
            )));
        }
        // Google verification code
        if(!$siteConfig->GoogleSiteVerification) {
            $arrayList->push(new ArrayData(array(
                'Type' => 'info',
                'Message' => 'No Google Verification code set. This can be set in: This can be set under: <a href="'.Director::absoluteBaseURL().'admin/settings'.'">Settings > Analytics</a>'
            )));
        }
        return $arrayList;
    }

}