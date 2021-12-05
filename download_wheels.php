<?php
error_reporting(E_ALL);
set_time_limit(0);
require_once "Common/Database_worker.php";
require_once "Tyres/Tyres.php";
require_once "Wheels/Wheels.php";


foreach($class_list as $row){
    require_once $row;
}
