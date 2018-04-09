<?php

session_start();
$_SESSION['pool']=array();
$pool=$_POST['pool'];
$_SESSION['pool']=$pool;
for($i=0;$i<6;$i++)
echo $_SESSION['pool'][$i];

?>