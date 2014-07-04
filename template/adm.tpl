<?php
session_start();
require_once('../config.php');
$adm = new controllerADM($_REQUEST['acao']);
?>