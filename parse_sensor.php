<?php
require_once "Common/Database_worker.php";
require_once "PressureSensor/PressureSensor.php";
require_once "PressureSensor/KolradPressureSensor.php";
require_once "PressureSensor/Tochki4PressureSensor.php";
require_once "PressureSensor/Okno2PresssureSensor.php";
$db = new Database_worker();


require_once "scripts/sensor/okno2_sensor.php";