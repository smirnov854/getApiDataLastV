<?php

require('libs/db_vehicle_sample.class.php');

$config['dbHost'] = 'localhost';
$config['dbUser'] = 'cf08116_diski';
$config['dbPassword'] = 'Diski123';
$config['dbName'] = 'cf08116_diski';

$mysql_link_id = mysqli_connect($config['dbHost'], $config['dbUser'], $config['dbPassword']) or die("Could not connect: " . mysqli_error());

mysqli_select_db($mysql_link_id, $config['dbName']);

$db = new DBVehicleSample();

$vendor = ( isset($_GET['vendor']) 	&& $_GET['vendor'] != "" ) 	? mysqli_real_escape_string($mysql_link_id, $_GET['vendor']) : null;
$car 	= ( isset($_GET['car'])		&& $_GET['car'] != "" ) 	? mysqli_real_escape_string($mysql_link_id, $_GET['car']) : null;
$year 	= ( isset($_GET['year']) 	&& $_GET['year'] != "" ) 	? (int) $_GET['year'] : null;
$mod 	= ( isset($_GET['mod']) 	&& $_GET['mod'] != "" ) 	? mysqli_real_escape_string($mysql_link_id, $_GET['mod']) : null;
$modify_list = [];
$year_list=  [];
$car_list = [];
$tyres_search = "";
$wheels_search = "";

if(!empty($vendor) && !empty($car) && !empty($year) && !empty($mod)){
    $data = $db->get_data($vendor, $car, $year,$mod);

    $tyres_factory = $data['tyres_factory'];
    $tyres_replace= $data['tyres_replace'];
    $all_tyres = $tyres_factory .'|'. $tyres_replace;

    $all_tyres = explode('|', $all_tyres);

    foreach ($all_tyres as $value) {
        $value = str_replace('/', '-', $value);
        $value = str_replace(' ', '-', $value);
        $value = str_replace('R', 'r', $value);
        $tyres_search = $tyres_search .','. $value;
    }


    $wheels_factory= $data['wheels_factory'];
    $wheels_replace= $data['wheels_replace'];

    $all_wheels = $wheels_factory .'|'. $wheels_replace;

    $all_wheels = explode('|', $all_wheels);

    foreach ($all_wheels as $value) {
        $value = str_replace('.', '-', $value);
        $value = str_replace(' ', '-', $value);
        $value = str_replace('E', 'e', $value);
        $value = str_replace('T', 't', $value);
        $wheels_search = $wheels_search .','. $value;
    }
}else{
    if(!empty($vendor) && !empty($car) && !empty($year)){
        $modify_list = $db->get_modifications($vendor, $car, $year);
    }else{
        if(!empty($vendor) && !empty($car) ){
            $year_list = $db->get_years($vendor, $car);
        }else{
            if(!empty($vendor)){
                $car_list = $db->get_cars($vendor);
            }
        }
    }
}



echo json_encode(
    [
        "car_list"=>$car_list,
        "year_list"=>$year_list,
        "modify_list"=>$modify_list,
        "tyres_search"=>$tyres_search,
        "wheels_search"=>$wheels_search,
    ]);