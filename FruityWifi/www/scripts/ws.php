<?php

class WebService {
	
	private $global_webserver;
	private $s;
	private $username;
	private $password;
	private $token;
	
	//public function __construct($username, $password)
	public function __construct($token)
	{
		
		//echo 'The class "', __CLASS__, '" was initiated!<br />';
		
		// Include Requests library
		include('Requests/Requests.php');
	
		// load Requests internal classes
		Requests::register_autoloader();
		
		$this->global_webserver = "http://localhost:8000";
		
		// Set up session
		$this->s = new Requests_Session($this->global_webserver);
		$this->s->headers['Accept'] = 'application/json';
		$this->s->useragent = 'RESTful API [FruityWifi]';
		
		// Set up login user/pass
		$this->username = $username;
		$this->password = $password;
		$this->token = $token;
		
	}
	
	public function __destruct()
	{
		//echo 'The class "', __CLASS__, '" was destroyed.<br />';
	}
	
	public function setProperty($newval)
	{
		$this->prop1 = $newval;
	}
 
	/*
	private function login()
	{
		$options = array('user' => $this->username, 'pass' => $this->password);

		$this->s->post($this->global_webserver."/login.php", array(), $options);
	}
	*/
	private function login()
	{
		$options = array('token' => $this->token);

		$this->s->post($this->global_webserver."/login.php", array(), $options);
	}
 
	public function getProperty()
	{
	    return $this->prop1 . "<br />";
	}
	
	public function setGetRequest($data)
	{
		$this->login();
		return $this->s->get($this->global_webserver."/".$data);
	}
	
	public function setPostRequest($data)
	{
		$this->login();
		return $this->s->get($this->global_webserver."/".$data);
	}
	
	
	public function getAllInterfaces()
	{
		$exec = "/sbin/ifconfig -a | cut -c 1-8 | sort | uniq -u |grep -v lo";
		exec($exec, $output);
		return json_encode($output);
	}

	public function getServiceStatus($service)
	{
		
		//$service = $_GET["service"];
		
		include "../config/config.php";
	
		if ($service = "wireless") {
		
			if ($ap_mode == "1") { 
				$ismoduleup = exec("ps auxww | grep hostapd | grep -v -e grep");
			} else if ($ap_mode == "2") {
				$ismoduleup = exec("ps auxww | grep airbase | grep -v -e grep");
			} else if ($ap_mode == "3") {
				$ismoduleup = exec("ps auxww | grep hostapd | grep -v -e grep");
			} else if ($ap_mode == "4") {
				$ismoduleup = exec("ps auxww | grep hostapd | grep -v -e grep");
			}
		
		} else if ($service = "3g_4g") {
			
		} else if ($service = "karma") {
		
		} else if ($service = "mana") {
		
		} else if ($service = "supplicant") {
		
		}
		
		if ($ismoduleup != "") {
			$output[0] = "Y";
		} else {
			$output[0] = "N";    
		}
		
		return json_encode($output);
		
	}
	
	// START|STOP Services
	public function setServiceStatus($service, $action)
	{
			
		if ($service = "wireless") {
			
			$url = "scripts/status_wireless.php?service=wireless&action=$action";
			$this->setPostRequest($url);
			
		} else if ($service = "3g_4g") {
			
		} else if ($service = "karma") {
		
		} else if ($service = "mana") {
		
		} else if ($service = "supplicant") {
		
		}
		
		if ($action == "start") {
			$output[0] = "true";
		} else {
			$output[0] = "false";    
		}
		
		return json_encode($output);
		
	}
	
	public function getModules()
	{
		exec("find ../modules -name '_info_.php' | sort", $output);
	
		for ($i=0; $i < count($output); $i++) {
			include $output[$i];
			$module_path = str_replace("_info_.php","",$output[$i]);
			//echo "<a href='$module_path'>$mod_name.$mod_version</a><br>";
			
			$modules[] = $mod_name;
		}
		
		return json_encode($modules);
		
	}
	
	public function getModuleStatus($module)
	{
		
		$file = "../modules/$module/_info_.php";
		
		if (file_exists($file)) {
			
			include $file;
			$ismoduleup = exec("$mod_isup");
			
			if ($ismoduleup != "") {
				$output[0] = "Y";
			} else {
				$output[0] = "N";    
			}
		
		} else {
			$output[0] = "-";
		}
		
		return json_encode($output);
		
	}
	
	
	// START|STOP Modules
	public function setModuleStatus($module, $action)
	{
		
		$url = "modules/$module/includes/module_action.php?service=$module&action=$action";
		$this->setPostRequest($url);
		
		if ($action == "start") {
			$output[0] = "true";
		} else {
			$output[0] = "false";    
		}
		
		return json_encode($output);
	
	}
	
}

/*
$ws = new WebClient("admin", "admin");
var_dump($ws->setGetRequest("page_config_adv.php"));


if ($service == "s_wireless") {
    $url = "scripts/status_wireless.php?service=wireless&action=$action";
	$ws->setGetRequest($url);
              
} else if ($service == "s_phishing") {
    $url = "scripts/status_phishing.php?service=phishing&action=$action";
	$ws->setGetRequest($url);
            
} else {
    $url = "modules/$service/includes/module_action.php?service=$service&action=$action&page=$page";
	$ws->setGetRequest($url);
	
}

*/

?>