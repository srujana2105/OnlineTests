<?php

include 'connection.php';
$q="select * from testdb.contests";
if($sql=$con->query($q)){
	//echo "haii";
	while($result=$sql->fetch_assoc()){
		echo $result['ContestName'];
	}
	
}else{
	echo 'error'.$con->error;
}



?>