<?php

include 'connection.php';
$q="select * from testdb.contests";
if($con->query($q)){
	echo "haii";
	while($result=$q->fetch_assoc()){
		echo $result['ContestName'];
	}
	
}else{
	echo 'error'.$con->error;
}



?>