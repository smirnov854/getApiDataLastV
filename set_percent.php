<?php
require_once "./Common/Database_worker.php";
$db = new Database_worker();
$id = $_POST['id'];
$percent = $_POST['percent'];

$db->update("parsing_source_list",["percent"=>$percent],$id);
echo json_encode(["status"=>200]);