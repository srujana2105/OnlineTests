<?php
session_start();
var_dump($_SESSION['ans']);
$_SESSION['ans'][2]='keerthana2';
var_dump($_SESSION['ans']);
?>