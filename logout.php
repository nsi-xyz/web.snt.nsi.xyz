<?php
include "./panel/include/db.php";
include "./include/functions.php";
include "./include/checksession.php";
if (isset($_GET["reset"])) {
    logout("./index.php", 1);
} else {
    logout("./index.php");
}