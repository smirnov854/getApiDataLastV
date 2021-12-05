<?php
error_reporting(E_ALL);
set_time_limit(0);
require_once "Common/Database_worker.php";
require_once "Tyres/Tyres.php";
require_once "Wheels/Wheels.php";
$db = new Database_worker();
$res = $db->do_sql("SELECT psl.* 
                    FROM parsing_source_list psl    
                    WHERE type='tyres'
                    ");

foreach($res as $row){
    require_once $row->class_path;
}

foreach($res as $row){
    $row->source::get_data();
}


/*

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



$tyres = new TerminalYstTyres();
$tyres->get_data();
*/
