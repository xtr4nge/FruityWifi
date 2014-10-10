<? 
/*
    Copyright (C) 2013-2014  xtr4nge [_AT_] gmail.com

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/ 
?>
<?
require_once "lib/nusoap.php";

$client = new nusoap_client("http://localhost/FruityWifi/wsdl/FruityWifi.php?wsdl", true);

$error = $client->getError();
echo $error;

if ($error) {
    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
}

/*

$result = $client->call("serviceAction", array("service" => "s_wireless", "action" => "start"));

if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Service</h2><pre>";
        echo $result;
        echo "</pre>";
    }
}

*/

function getStatus2($client, $service)
{
    //$result = $client->call("getStatus", array("service" => "s_wireless", "action" => "start"));
    $result = $client->call("getStatus", array("service" => $service));
    
    if ($client->fault) {
        echo "<h3>Fault</h3><pre>";
        print_r($result);
        echo "</pre>";
    }
    else {
        $error = $client->getError();
        if ($error) {
            echo "<h3>Error</h3><pre>" . $error . "</pre>";
        }
        else {
            echo "<h3>getStatus</h3><pre>";
            echo $service .":". $result;
            echo "</pre>";
        }
    }
}

function serviceAction($client, $service, $action)
{
    $result = $client->call("serviceAction", array("service" => "$service", "action" => "$action"));
}

function moduleAction($client, $service, $action)
{
    $result = $client->call("moduleAction", array("module" => "$service", "action" => "$action"));
}

function getStatus($client, $service)
{
    //$result = $client->call("serviceAction", array("service" => "$service", "action" => "$action"));
    $result = $client->call("getStatus", array("service" => "$service"));
    //$result = $client->call("getStatus", array("service" => $service));
    
    return $result;
    
    /*
    
    if ($client->fault) {
        echo "<h3>Fault</h3><pre>";
        print_r($result);
        echo "</pre>";
    }
    else {
        $error = $client->getError();
        if ($error) {
            echo "<h3>Error</h3><pre>" . $error . "</pre>";
        }
        else {
            echo $service .":". $result;
        }
    }
    */
}

$operation = $_POST["operation"];
$service = $_POST["service"];
$action = $_POST["action"];


if ($operation == "getStatus2")
{	
    if ($service == "wireless") {
        $dump[0] = "false";

        //Return results (array)
        echo json_encode($dump);
    } else if ($service == "supplicant") {
        $dump[0] = "true";

        //Return results (array)
        echo json_encode($dump);
    } else if ($service == "karma") {
        $dump[0] = "true";

        //Return results (array)
        echo json_encode($dump);
    } else if ($service == "phishing") {
        $dump[0] = "true";

        //Return results (array)
        echo json_encode($dump);
    } else {
        $dump[0] = "false";
        echo json_encode($dump);
    }	
} 
else if ($operation == "serviceAction") 
{
	
    if ($action == "start")
    {
        $dump[0] = "true";
    }
    else
    {
        $dump[0] = "false";
    }
    
    if ($service == "s_wireless") {
        //Return results (array)
        serviceAction($client, $service, $action);
        echo json_encode($dump);
    } else if ($service == "s_supplicant") {
        //Return results (array)
        serviceAction($client, $service, $action);
        echo json_encode($dump);
    } else if ($service == "s_karma") {
        //Return results (array)
        serviceAction($client, $service, $action);
        echo json_encode($dump);
    } else if ($service == "s_phishing") {
        //Return results (array)
        serviceAction($client, $service, $action);
        echo json_encode($dump);
    }

    /*

    if ($service == "mod_ngrep") {
            //Return results (array)
            moduleAction($client, $service, $action);
            echo json_encode($dump);
    } else if ($service == "mod_sslstrip") {
            //Return results (array)
            moduleAction($client, $service, $action);
            echo json_encode($dump);
    } else if ($service == "mod_dnsspoof") {
            //Return results (array)
            moduleAction($client, $service, $action);
            echo json_encode($dump);
    } else if ($service == "mod_mdk3") {
            //Return results (array)
            moduleAction($client, $service, $action);
            echo json_encode($dump);
    } else if ($service == "mod_squid3") {
            //Return results (array)
            moduleAction($client, $service, $action);
            echo json_encode($dump);
    } else if ($service == "mod_autostart") {
            //Return results (array)
            moduleAction($client, $service, $action);
            echo json_encode($dump);
    } else if ($service == "mod_kismet") {
            //Return results (array)
            moduleAction($client, $service, $action);
            echo json_encode($dump);
    } else if ($service == "mod_captive") {
            //Return results (array)
            moduleAction($client, $service, $action);
            echo json_encode($dump);
    } else if ($service == "mod_urlsnarf") {
            //Return results (array)
            moduleAction($client, $service, $action);
            echo json_encode($dump);
    } else if ($service == "mod_responder") {
            //Return results (array)
            moduleAction($client, $service, $action);
            echo json_encode($dump);
    } else if ($service == "mod_rpitwit") {
            //Return results (array)
            moduleAction($client, $service, $action);
            echo json_encode($dump);
    } else if ($service == "mod_whatsapp") {
            //Return results (array)
            moduleAction($client, $service, $action);
            echo json_encode($dump);
    }

    */

    exec("find ../modules -name '_info_.php'",$output);

    for ($i=0; $i < count($output); $i++) {
        include $output[$i];

        if ($service == "mod_$mod_name") {
            //Return results (array)
            moduleAction($client, $service, $action);
            echo json_encode($dump);
        }
    }

}
else if ($operation == "getStatus") 
{	
    if ($service != "as_wireless") {
        //Return results (array)
        $result = getStatus($client, $service);
        
        if($result == "Y")
        {
            $dump[0] = "true";
        } 
        else
        {
            $dump[0] = "false";
        }
        echo json_encode($dump);

    } else if ($service == "s_supplicant") {
        //Return results (array)
        echo json_encode($dump);
    }

}

?>