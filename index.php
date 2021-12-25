<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
set_time_limit(0);
require_once "Common/Database_worker.php";
require_once "Tyres/Tyres.php";
require_once "Wheels/Wheels.php";
require_once "PressureSensor/PressureSensor.php";
require_once "Fitting/Fitting.php";
require_once "clear_data.php";

$db = new Database_worker();
$res = $db->do_sql("SELECT psl.* FROM parsing_source_list psl");

foreach ($res as $row) {
    require_once $row->class_path;
}

$db = new Database_worker();

foreach ($res as $row) {

    if($row->type != 'wheels'){
        continue;
    }
/*
    if($row->source != 'TerminalYstWheels'){
        continue;
    }*/

    @$db->update("parsing_source_list",["start_parse"=>date('Y-m-d H:i:s')],$row->id);
    //@$sql = "DELETE FROM parsing_".$row->type." WHERE source LIKE '%".$row->source."%'";
    //@$db->do_sql($sql);
    require_once "scripts/{$row->type}/{$row->file_name}";
    $db->reconnect();
    $cnt = $db->do_sql("SELECT COUNT(1) as cnt 
                        FROM parsing_".$row->type." 
                        WHERE source LIKE '".$row->source."'");
    @$db->do_sql("UPDATE parsing_".$row->type." SET price_edited=price*".$row->percent." WHERE source LIKE '".$row->source."'");
    @$db->update("parsing_source_list",[
        "end_parse"=>date('Y-m-d H:i:s'),
        "total_goods"=>$cnt[0]->cnt
        ],$row->id);
}


