<?php 
/*
 * PHP XMLRPC - Server XMLRPC
 * Author: Santpapen
 * 
 * Date: 09/03/2017
 */


# -- Import File   --
require("config.inc");
require("functions.inc");
require_once("filter.inc");
require("ipsec.inc");
require("vpn.inc");
require("shaper.inc");
require("xmlrpc_server.inc");
require("xmlrpc.inc");
require("captiveportal.inc");
# -- DATA --
$base_db_path = '/var/db/';

# -- Methods --
function read_db ($dbname){
  # READ CAPTIVEPORTAL DATABASE
  # -- DATA --
  $cpdb = array();
  $dbname = strtolower($dbname);
  $db_path = $base_db_path.$dbname;
  
  # -- SQLConnection --
  $DB = new SQLite3 ($db_path);
  $DB -> busyTimeout (60000);
    if ($DB){
      $response = $DB -> query ("SELECT * FROM captiveportal");
         while ($row = $response -> fetchArray ()) {
            $cpdb[] = $row;
         }
         $DB -> close();
    }
  $size = count ($cpdb);
      for ($i =0;$i<$size;$i++){
        // Parse data of captiveportal
                $result[$i]['ip']=$cpdb[$i]['ip'];
                $result[$i]['username']=$cpdb[$i]['username'];
                $result[$i]['mac']=$cpdb[$i]['mac'];
                $result[$i]['sessionid']=$cpdb[$i]['sessionid'];
                $result[$i]['pipeno']=$cpdb[$i]['pipeno'];
      }
 # Return data
 return new XML_RPC_Response (XML_RPC_encode($result));
}

# -- Define Methods --
$server = new XML_RPC_Server(
	array(
		'Delete'=>array('function'=>'Delete'),
		'read_db'=>array('function'=>'read_db'),
		));
?>
