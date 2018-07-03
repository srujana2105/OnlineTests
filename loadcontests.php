<?php
include 'connection.php';
session_start();
//$name=$_POST['rname'];
//echo " hello from php";
$q2="select * from testdb.contests";
//$q1="DELETE FROM testdb.contests WHERE ContestName='$name'";
//$res=$con->query($q1);
$i=0;
if($sql=$con->query($q2)){
	//echo "haii";
	while($result=$sql->fetch_assoc()){
		$res[$i++]=$result['ContestName'];
	}
}
$json_ar = json_encode($res);
     echo $json_ar;
?>