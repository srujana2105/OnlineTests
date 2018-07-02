<?php
 include 'connection.php';
$name=$_POST['name'];
$sem=$_POST['sem'];
$sub=$_POST['sub'];
$dur=$_POST['dur'];
$ques=json_decode($_POST['ques']);
if($name||$sem||$sub||$dur){

	// create tables for each and every contest
	//$q="create table ".$name."()";
	
	//$q="create table testdb.result".$name." (`QID` INT(11) NOT NULL , `Question` VARCHAR(100) NOT NULL , `answer` VARCHAR(100) NOT NULL , `correct` VARCHAR(100) NOT NULL)";
	//$q1="CREATE TABLE testdb.contest$name (`Name` VARCHAR(6) NOT NULL ,`SEMESTER` INT(3) NOT NULL , `subject` VARCHAR(5) NOT NULL , `no.ofque` INT(10) , PRIMARY KEY (`name`(6)))";
	//$q1="INSERT INTO `contests` (`ContestName`, `subject`, `semester`, `no.ofque`) VALUES ('cont1', 'general', 3, 10)";
	$q1="INSERT INTO testdb.contests (`ContestName`, `subject`, `semester`, `duration`) VALUES ('$name', '$sub', '$sem', '$dur')";
	if($con->query($q1)==true){
echo "row added to contests";
        $id=$con->insert_id;
        echo "ai id:".$id;
	}else{
		echo "error1 <br>".$con->error;
	}
	$q="CREATE TABLE testdb.result$id (`Rollno` VARCHAR(12) NOT NULL , ";
	//a$nq VARCHAR(100) NOT NULL , PRIMARY KEY (`Rollno`(12)))"; 
	for($i=1;$i<=sizeof($ques);$i++){ 
	$q.= "`a$i` VARCHAR(100) NOT NULL , "; 
	}
	$q .= "PRIMARY KEY (`Rollno`(12)))";
   if($con->query($q)==true){
	echo "result table created successfully";
  }else{
	   echo "error";
   }
    $sql="";
    for($i=0;$i<sizeof($ques);$i++){echo $ques[$i];}
    for($i=0;$i<sizeof($ques);$i++){
    $sql.="INSERT INTO testdb.contest_question (`ContestId`,`QID`) VALUES ('$id','$ques[$i]');";
    }
    if($con->multi_query($sql)==true){
	echo "contest_question updated successfully";
  }else{
	   echo "error:".$con->error."sql:".$sql;
   }
	
}
?>