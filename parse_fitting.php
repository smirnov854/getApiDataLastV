<?php
require_once "Common/Database_worker.php";
require_once "Fitting/Fitting.php";
require_once "Fitting/Tochki4Fitting.php";
require_once "Fitting/KolradFitting.php";


$db = new Database_worker();
require_once "scripts/fitting/kolrad_fitting.php";