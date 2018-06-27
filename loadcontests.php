<?php
include 'connection.php';
session_start();
//$name=$_POST['rname'];
//echo " hello from php";
$q2="select * from testdb.contests";
//$q1="DELETE FROM testdb.contests WHERE ContestName='$name'";
//$res=$con->query($q1);
if($sql=$con->query($q2)){
	//echo "haii";
	while($result=$sql->fetch_assoc()){
		echo $result['ContestName'];
	}
}
?>