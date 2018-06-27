<?php
include 'connection.php';
session_start();
$id=$_POST['id'];
$res=[]; 
$que=[];
$ans=[];
$c=0;
$q="select * from testdb.result1 where Rollno=".$id;
$exec=$con->query($q);
if($exec==true){
	//echo "executed";
	
if($exec->num_rows>0){
while($result=$exec->fetch_assoc()){
	for($i=1;$i<=6;$i++){
	$res[$i]=$result['a'.$i];	
	}		//echo $result['q'.$i].$result['a'.$i];
}
	}
	}
$q="select Question,Answer from testdb.questions";
$exec=$con->query($q);
if($exec==true){
	//echo "executed";
	
if($exec->num_rows>0){
	$i=1;
while($result=$exec->fetch_assoc()){
	
	$que[$i]=$result["Question"];	
	$ans[$i++]=$result["Answer"];
		//echo $result['q'.$i].$result['a'.$i];
}
	}
	}
echo "<table border='1'><tr><th>Question</th><th>Submitted Answer</th></tr>";

for($i=1;$i<=6;$i++){ 
	if($res[$i]==$ans[$i]){
		$c++;
	}
echo "<tr><td>$que[$i]</td><td>$res[$i]</td></tr>";
}
	echo "</table>";
echo " Score is:$c"
//	$json_ar = json_encode($res);
//     echo $json_ar;


?>