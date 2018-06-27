<?php
include 'connection.php';

$q="select * from testdb.result";
$exec=$con->query($q);
if($exec){
	
	if($exec->num_rows>0){
		echo "<table border='1'><tr><th>Rollno</th><th>Score</th></tr>";
		while($result=$exec->fetch_assoc()){
			echo "<tr><td>".$result['Rollno']."</td><td>".$result['score']."</td></tr>";
		}
		echo "</table>";
	}
}
?>