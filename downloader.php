<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
set_time_limit(0);

require_once "Common/Database_worker.php";
require_once "Tyres/Tyres.php";
require_once "Wheels/Wheels.php";
require_once "Fitting/Fitting.php";
require_once "PressureSensor/PressureSensor.php";

$param = $_GET['param'];
$db = new Database_worker();
if(empty($param)){
    echo "Need to setup param";
    die();
}
$res = $db->do_sql("SELECT psl.* FROM parsing_source_list psl WHERE type='$param'");

foreach($res as $row){
    require_once $row->class_path;
}

foreach($res as $row){
    $db->update("parsing_source_list",["last_dl_date"=>date('Y-m-d H:i:s')],$row->id);
    $row->source::get_data();
    $db->update("parsing_source_list",["finish_dl"=>date('Y-m-d H:i:s')],$row->id);
}
//test  123