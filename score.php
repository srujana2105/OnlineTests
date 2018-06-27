<?php
include 'connection.php';

    session_start();  
//$q="create table testdb.".$_SESSION['rollno']." (`QID` INT(11) NOT NULL , `Question` VARCHAR(100) NOT NULL , `answer` VARCHAR(100) NOT NULL , `correct` VARCHAR(100) NOT NULL)";
//if($con->query($q)==true){
//	echo "table created successfully";
//}
     $query="select QID,Question,Answer from testdb.questions";
    $sql=$con->query($query);
$c=0;
$j=1;
//$ans=new array();
$ans2=$_POST['ans'];
//print_r($ans2);
$ans=explode(",",$ans2);
print_r($ans);
//$res2=[];
//$res2[]=" ";
$roll=$_SESSION['rollno'];
//print_r($_SESSION);
if($sql->num_rows >0){
				while($result2=$sql->fetch_assoc()){
					echo $result2['Answer'];
					echo $ans[$j];
					$qid=$result2['QID'];
					$que[$j]=$result2['Question'];
//					$q1="insert into testdb.name(Rollno,QID,Question,answer,correct) values(".$roll.",".$qid.",'".$que."','".$_SESSION['answers'][$j]."','".$result2['Answer']."')";
//					if($con->query($q1)==true){
//						echo "entered";
//					}
					
				if($result2['Answer'] == $ans[$j]){
					$c++;
					//echo $c;
				}
					echo $c;
					$j=$j+1;
				}

	$q1="insert into testdb.result1(Rollno,a1,a2,a3,a4,a5,a6) values(".$roll.",'".$ans[1]."','".$ans[2]."','".$ans[3]."','".$ans[4]."','".$ans[5]."','".$ans[6]."')";
					if($con->query($q1)==true){
						echo " you submitted";
					}
}
echo $c;

//$q2="INSERT INTO `result` (`Rollno`, `score`) VALUES ('100515733014', '3')";
$q2="insert into testdb.result(Rollno,score) values('".$roll."',".$c.")";
if($con->query($q2)== true){
echo "Your score is".$c;	
}

?>	 
