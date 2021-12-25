<?php
require_once "Common/Database_worker.php";
$db = new Database_worker();
$sql = "UPDATE parsing_wheels SET hash= md5(CONCAT(lower(brand),pn,pcd,diameter,et,lower(model)))";
@$db->do_sql($sql);
$sql = "UPDATE parsing_tyres SET hash=md5(CONCAT(lower(brand),width,profile,diameter,speed_index,lower(model)));";
@$db->do_sql($sql);