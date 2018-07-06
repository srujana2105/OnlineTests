<?php
include 'connection.php';
session_start();
$cont=$_POST['cont'];
$_SESSION['cont']=$cont;
$query="select * from testdb.result".$cont." where Rollno=".$_SESSION['rollno'];
//echo $cont." ".$query;
 $sql=$con->query($query);
//$sql2=$con->query($_POST['sql']);


if($sql->num_rows ==1){
	//echo " already taken";
	//header("Location: main2.php");
    
}else{
	//echo $query;
	//while($result=$sql->fetch_assoc()){
	//echo $result['Rollno'];
	//}
	echo "main.php";
	//echo "<script> alert('You have not taken test'); </script>";
//header("Location: main.php");	
}
?>