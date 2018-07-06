

<?php
include 'connection.php';

    session_start();  

     $query="select QID,Question,Answer from testdb.q".$_SESSION['cont'];
    $sql=$con->query($query);
$c=0;
$na=0;
$w=0;
$j=1;

$ans2=$_POST['ans'];

$ans=explode(",",$ans2);

$roll=$_SESSION['rollno'];
echo "<head><style>div{margin-left:10px;}</style></head>";
echo "<div>RollNo:".$_SESSION['rollno']."</div><div>UserName:".$_SESSION['username']."</div>";
echo "<div><h1>Here are you answers</h1>";
echo "<div><table border=1 style='margin-top:-170px'><tr><th>question</th>  <th>Your Answer</th>  <th>correct Answer</th></tr><br>";
if($sql->num_rows >0){
				while($result2=$sql->fetch_assoc()){
					$qid=$result2['QID'];
					$que[$j]=$result2['Question'];
//					$q1="insert into testdb.name(Rollno,QID,Question,answer,correct) values(".$roll.",".$qid.",'".$que."','".$_SESSION['answers'][$j]."','".$result2['Answer']."')";
//					if($con->query($q1)==true){
//						echo "entered";
//					}
					echo "<tr><td>".$result2['Question']."</td><td> ".$ans[$j]."</td><td> ".$result2['Answer']."</td></tr> <br>";
					if($ans[$j]==' '){
						$na++;
					}else{ 
				if($result2['Answer'] == $ans[$j]){
					$c++;
				}else{
					$w++;
				}
					
					}
					//echo "hello ".$result2['Answer']." ".$ans[$j];
					$j=$j+1;
				}
	echo "</table></div>";

	$q1="insert into testdb.result".$_SESSION['cont']."(Rollno";
	for($j=1;$j<=$_SESSION['nq'];$j++){
		$q1 .=",a".$j;
	}
	$q1 .=") values(".$roll.",'";
	
	for($j=1;$j<$_SESSION['nq'];$j++){
		
		$q1 .=$ans[$j]."','";
	}
	$q1 .=$ans[$_SESSION['nq']]."')";
		
//		",'".$ans[1]."','".$ans[2]."','".$ans[3]."','".$ans[4]."','".$ans[5]."','".$ans[6]."','".$ans[7]."','".$ans[8]."','".$ans[9]."','".$ans[10]."')";
	if($con->query($q1)==true){
						echo " you submitted";
					}else
		echo $con->error;
}
//echo $c;
echo "<div>No. of Correct Answers:".$c."<br>";
echo "No. of Wrong Answers:".$w."<br>";
echo "No. of questions not attempted:".$na."<br></div>";
//$q2="INSERT INTO `result` (`Rollno`, `score`) VALUES ('100515733014', '3')";
$q2="insert into testdb.result(Rollno,score) values('".$roll."',".$c.")";
if($con->query($q2)== true){
echo "Your score is".$c."<br>";	
}else
	echo $con->error;

echo "<div><h2>Thank you for taking Test</h2>
<button onclick='window.location=`main2.php`'>Go back to Test</button></div></div>";
?>	 
