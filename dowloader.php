<?php
error_reporting(E_ALL);
set_time_limit(0);
require_once "Common/Database_worker.php";
require_once "Tyres/Tyres.php";
require_once "Wheels/Wheels.php";
$param = $_GET['param'];
$db = new Database_worker();
if(empty($param)){
    echo "Need to setup param";
    die();
}
$res = $db->do_sql("SELECT psl.* 
                    FROM parsing_source_list psl    
                    WHERE type='$param'
                    ");

foreach($res as $row){
    require_once $row->class_path;
}

foreach($res as $row){
    $row->source::get_data();
}
