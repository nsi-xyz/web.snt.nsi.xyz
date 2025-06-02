<?php
require_once __DIR__ . '/include/bootstrap.php';

$session->logout("./index.php", urldecode(Page::getGetMethod('msg')));