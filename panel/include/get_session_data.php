<?php
include("./db.php");
include("../../include/functions.php");
include("../../include/checksession.php");

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["id_session"])) {
    $id_session = $data["id_session"];
    $data_session = getSessionData($db, $id_session);
    echo json_encode($data_session);
}