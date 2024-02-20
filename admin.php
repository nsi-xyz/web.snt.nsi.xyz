<?php
include("./include/checksession.php");
include("./include/functions.php");
?>
<?php
if (isset($_COOKIE["admin"])) {
    include("./admin/panel.php");
} else {
    include("./admin/login.php");
}
?>