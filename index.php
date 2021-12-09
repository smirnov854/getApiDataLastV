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
$res = $db->do_sql("SELECT psl.* 
                    FROM parsing_source_list psl");

foreach ($res as $row) {
    require_once $row->class_path;
}

$db = new Database_worker();

foreach ($res as $row) {
    //echo $row->type."<br/>";
    //echo $row->file_name . "<br/>";
    /*
    if($row->type != "sensor"){
        continue;
    }*/
/*
    if($row->file_name != 'optwspitality_wheels.php'){
        continue;
    }*/
    @$db->update("parsing_source_list",["start_parse"=>date('Y-m-d H:i:s')],$row->id);
    @$sql = "DELETE FROM parsing_".$row->type." WHERE source LIKE '%".$row->source."%'";
    @$db->do_sql($sql);
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
$sql = "UPDATE parsing_wheels SET hash= md5(CONCAT(lower(brand),pn,pcd,diameter,et,lower(model)))";
@$db->do_sql($sql);
$sql = "UPDATE parsing_tyres SET hash=md5(CONCAT(lower(brand),width,profile,diameter,speed_index));";
@$db->do_sql($sql);

$sql = "
CREATE TABLE result_tyres AS
SELECT pt.id, pt.source, pt.name, pt.type,
       t1.model_name as model, t1.size_radius as diameter, t1.size_width as width,
       t1.size_profile as profile, pt.load_index, t1.speed_index,
       t1.model_stud, t1.rof_flag, ROUND(pt.price_edited, 2) as price_edited,
       pt.photo_url, t1.season_id, t1.vendor_name as brand,
       pt.cae, pt.amount,t1.season_id as season
FROM tyres_import_prepare t1
LEFT JOIN parsing_tyres pt ON pt.hash=t1.hash
WHERE pt.amount>0 and pt.price_edited>0 
";
@$db->do_sql($sql);

$sql = "
CREATE TABLE result_wheels AS
SELECT  pw.id, pw.source, pw.name,
        t1.model_name as model,
        pw.type, t1.diameter, pw.color,
        t1.pcd_first, t1.pcd_second,
        t1.et, pw.photo_url, t1.vendor_name as brand,t1.width,
        ROUND(pw.price_edited,2) as price_edited,pw.cae,pw.amount
FROM wheels_import_prepare t1
LEFT JOIN parsing_wheels pw ON pw.hash=t1.hash
WHERE pw.amount>0 and pw.price_edited>0
";
@$db->do_sql($sql);