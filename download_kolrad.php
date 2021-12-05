<?php
error_reporting(E_ALL);
set_time_limit(0);
require_once "Common/Database_worker.php";
require_once "Tyres/Tyres.php";
require_once "Wheels/Wheels.php";
require_once "Wheels/KolradWheels.php";

$db = new Database_worker();
$wheels = new KolradWheels();

$db->update("parsing_source_list",["last_dl_date"=>date('Y-m-d H:i:s')],17);
$db->update("parsing_source_list",["last_dl_date"=>date('Y-m-d H:i:s')],21);
$wheels->get_kolrad_data();
$db->reconnect();
$db->update("parsing_source_list",["finish_dl"=>date('Y-m-d H:i:s')],17);
$db->update("parsing_source_list",["finish_dl"=>date('Y-m-d H:i:s')],21);