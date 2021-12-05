<?php
error_reporting(E_ALL);
set_time_limit(0);
require_once "Common/Database_worker.php";
require_once "Tyres/Tyres.php";
require_once "Wheels/Wheels.php";
$class_list = [
    "Tyres/DiscoverTyres.php",
    "Tyres/DuploTyres.php",
    "Tyres/OknoTyres.php",
    "Tyres/OptKolesaDaromTyres.php",
    "Tyres/Tochki4Tyres.php",
    "Tyres/TreckTyreTyres.php",
    "Tyres/VianorTyres.php",
    "Tyres/TerminalYstTyres.php",

    "Wheels/DiscoverWheels.php",
    "Wheels/DuploWheels.php",
    "Wheels/KolradWheels.php",
    "Wheels/Okno2Wheels.php",
    "Wheels/OptKolesaDaromWheels.php",
    "Wheels/OptWspitality.php",
    "Wheels/Tochki4Wheels.php",
    "Wheels/TrekTyreWheels.php",
    "Wheels/VianorWheels.php",
];

foreach($class_list as $row){
    require_once $row;
}

$tyres = new TreckTyreTyres();
$tyres->get_data();

$tyres = new DiscoverTyres();
$tyres->get_data();

$duplo_tyres = new DuploTyres();
$duplo_tyres->get_data();

$tyres = new OknoTyres();
$tyres->get_data();

$tyres = new VianorTyres();
$tyres->get_data();

$wheel = new DiscoverWheels();
$wheel->get_data();

$duplo_wheel = new DuploWheels();
$duplo_wheel->get_data();

$tyres = new KolradWheels();
$tyres->get_data();


