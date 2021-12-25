<?php
ini_set("display_errors",1);
set_time_limit(0);
error_reporting(E_ALL);
require_once "./Common/Database_worker.php";

$db = new Database_worker();


$file_handle = fopen("./result/tyres.csv","w");
$header = [
    "id",
    "source",
    "search_field",
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
    "photo_url",
    "season",
    "brand",
    "price_edited",
    "cae",
    "amount"
];

fputcsv($file_handle,$header,";",'"');

for($i=0;$i<100000;$i+=500){
    $tyres = $db->do_sql("SELECT * FROM result_tyres LIMIT 500 OFFSET $i");
    if(count($tyres) ==0){
        break;
    }
    foreach($tyres as $row){
        $arr = [
            "id"=>$row->id,
            "source"=>$row->source,
            "search_field"=>$row->width."/".$row->profile." R".$row->diameter,
            "name"=>$row->name,
            "type"=>$row->type,
            "model"=>$row->model,
            "diameter"=>$row->diameter,
            "width"=>$row->width,
            "profile"=>$row->profile,
            "load_index"=>$row->load_index,
            "speed_index"=>$row->speed_index,
            "pins"=>$row->model_stud,
            "runflat"=>$row->rof_flag,
            "photo_url"=>$row->photo_url,
            "season"=>$row->season,
            "brand"=>$row->brand,
            "price_edited"=>$row->price_edited,
            "cae"=>$row->cae,
            "amount"=>$row->amount
        ];
        fputcsv($file_handle,$arr,";",'"');
    }
}

fclose($file_handle);


$header = [
    "id",
    "source",
    "search_field",
    "name",
    "model",
    "type",
    "diameter",
    "color",
    "pn",
    "pcd",
    "et",
    "photo_url",
    "brand",
    "price_edited",
    "cae",
    "width",
    "amount",
    "dia"
];

$file_handle = fopen("./result/wheels.csv","w");
fputcsv($file_handle,$header,";",'"');
for($i=0;$i<100000;$i+=500) {
    $wheels = $db->do_sql("SELECT * FROM result_wheels LIMIT 500 OFFSET $i");
    if(count($wheels) ==0){
        break;
    }
    foreach ($wheels as $row) {
        $arr = [
            "id" => $row->id,
            "source" => $row->source,
            "search_field" => $row->width . " x " . $row->diameter . " ET" . $row->et,
            "name" => $row->name,
            "model" => $row->model,
            "type" => $row->type,
            "diameter" => $row->diameter,
            "color" => $row->color,
            "pn" => $row->pcd_first,
            "pcd" => $row->pcd_seсond,
            "et" => $row->et,
            "photo_url" => $row->photo_url,
            "brand" => $row->brand,
            "price_edited" => $row->price_edited,
            "cae" => $row->cae,
            "width" => $row->width,
            "amount" => $row->amount,
            "dia"=>$row->dia
        ];
        fputcsv($file_handle, $arr, ";", '"');
    }
}
fclose($file_handle);


$sensor = $db->do_sql("SELECT * FROM parsing_sensor WHERE amount>0");
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
        "cae"=>$row->cae,
        "amount"=>$row->amount
    ];
    fputcsv($file_handle,$arr,";",'"');
}
fclose($file_handle);

$fitting = $db->do_sql("SELECT * FROM parsing_fitting WHERE amount>0");
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
        "cae"=>$row->cae,
        "amount"=>$row->amount
    ];
    fputcsv($file_handle,$arr,";",'"');
}
fclose($file_handle);
