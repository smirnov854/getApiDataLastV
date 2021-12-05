<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
require_once "./Common/Database_worker.php";

$db = new Database_worker();
$tyres = $db->do_sql("SELECT * FROM parsing_tyres");

$file_handle = fopen("./result/tyres.csv","w");
$header = [
    "id",
    "source",
    "name",
    "type",
    "model",
    "diameter",
    "width",
    "profile",
    "load_index",
    "speed_index",
    "pins",
    "runflat",
    "price",
    "price_retail",
    "photo_url",
    "season",
    "brand",
    "price_edited",
    "cae",
    "amount"
];

fputcsv($file_handle,$header,";",'"');
foreach($tyres as $row){
    $arr = [
        "id"=>$row->id,
        "source"=>$row->source,
        "name"=>$row->name,
        "type"=>$row->type,
        "model"=>$row->model,
        "diameter"=>$row->diameter,
        "width"=>$row->width,
        "profile"=>$row->profile,
        "load_index"=>$row->load_index,
        "speed_index"=>$row->speed_index,
        "pins"=>$row->pins,
        "runflat"=>$row->runflat,
        "price"=>$row->price,
        "price_retail"=>$row->price_retail,
        "photo_url"=>$row->photo_url,
        "season"=>$row->season,
        "brand"=>$row->brand,
        "price_edited"=>$row->price_edited,
        "cae",
        "amount"
    ];
    fputcsv($file_handle,$arr,";",'"');
}
fclose($file_handle);


$wheels = $db->do_sql("SELECT * FROM parsing_wheels");
$header = [
    "id",
    "source",
    "name",
    "model",
    "type",
    "diameter",
    "color",
    "pn",
    "pcd",
    "et",
    "price",
    "price_retail",
    "photo_url",
    "brand",
    "price_edited",
    "cae",
    "amount"
];

$file_handle = fopen("./result/wheels.csv","w");
fputcsv($file_handle,$header,";",'"');
foreach($wheels as $row){
    $arr = [
        "id"=>$row->id,
        "source"=>$row->source,
        "name"=>$row->name,
        "model"=>$row->model,
        "type"=>$row->type,
        "diameter"=>$row->diameter,
        "color"=>$row->color,
        "pn"=>$row->pn,
        "pcd"=>$row->pcd,
        "et"=>$row->et,
        "price"=>$row->price,
        "price_retail"=>$row->price_retail,
        "photo_url"=>$row->photo_url,
        "brand"=>$row->brand,
        "price_edited"=>$row->price_edited,
        "cae",
        "amount"
    ];
    fputcsv($file_handle,$arr,";",'"');
}
fclose($file_handle);


$sensor = $db->do_sql("SELECT * FROM parsing_sensor");
$header = [
    "id",
    "source",
    "name",
    "model",
    "brand",
    "price",
    "price_retail",
    "photo_url",
    "price_edited",
    "cae",
    "amount"
];

$file_handle = fopen("./result/sensor.csv","w");
fputcsv($file_handle,$header,";",'"');
foreach($sensor as $row){
    $arr = [
        "id"=>$row->id,
        "source"=>$row->source,
        "name"=>$row->name,
        "model"=>$row->model,
        "brand"=>$row->brand,
        "price"=>$row->price,
        "price_retail"=>$row->price_retail,
        "photo_url"=>$row->photo_url,
        "price_edited"=>$row->price_edited,
        "cae",
        "amount"
    ];
    fputcsv($file_handle,$arr,";",'"');
}
fclose($file_handle);

$fitting = $db->do_sql("SELECT * FROM parsing_fitting");
$header = [
    "id",
    "source",
    "name",
    "price",
    "photo_url",
    "price_edited",
    "cae",
    "amount"
];

$file_handle = fopen("./result/fitting.csv","w");
fputcsv($file_handle,$header,";",'"');
foreach($fitting as $row){
    $arr = [
        "id"=>$row->id,
        "source"=>$row->source,
        "name"=>$row->name,
        "price"=>$row->price,
        "photo_url"=>$row->photo_url,
        "price_edited"=>$row->price_edited,
        "cae",
        "amount"
    ];
    fputcsv($file_handle,$arr,";",'"');
}
fclose($file_handle);
