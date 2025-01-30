<?php
include("./db.php");
include("../../include/functions.php");
include("../../include/checksession.php");

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["id_session"])) {
    $id_session = $data["id_session"];
    $array = getRowsCustom($db, "SELECT us.id AS id, us.pseudo AS pseudo, us.id_session AS id_session, usl.id_puzzle AS id_puzzle, usl.finished_at AS finished_at, us.joined_at AS joined_at FROM users_session us LEFT JOIN users_session_logs usl ON us.pseudo = usl.pseudo AND us.id_session = usl.id_session WHERE us.id_session = $id_session;", 0);
    $data_session = [];
    foreach ($array as $row) {
        $pseudo = $row["pseudo"];
        if (!isset($data_session[$pseudo])) {
            $data_session[$pseudo] = [
                "id" => (int)$row["id"],
                "pseudo" => $row["pseudo"],
                "id_session" => (int)$row["id_session"],
                "joined_at" => $row["joined_at"],
                "puzzles" => [],
                "finished_at" => null,
            ];
        }
        if (!empty($row["id_puzzle"])) {
            $data_session[$pseudo]["puzzles"][] = [
                (int)$row["id_puzzle"], 
                $row["finished_at"]
            ];
        }
    }
    foreach ($data_session as &$player) {
        $puzzles = $player["puzzles"];
        if (count($puzzles) == 10) {
            $lastFinishedDate = max(array_column($puzzles, 1));
            $player["finished_at"] = $lastFinishedDate;
        }
    }
    echo json_encode(array_values($data_session));
}