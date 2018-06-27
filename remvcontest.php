
<?php
include 'connection.php';
$name=$_POST['rname'];
$q2="DROP TABLE testdb.result$name";
$q1="DELETE FROM testdb.contests WHERE ContestName='$name'";
if($con->query($q1)){
	echo "contest removed successfully";
}else{
	echo "error in removing contest";
}
if($con->query($q2)){
	echo "contest data is removed successfully";
}else{
	echo "error2";
}
?>