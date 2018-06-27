<?php
include 'connection.php';

    session_start(); 
//$_SESSION['correct']=array();
		//$ans=$_POST['ans'];
			$ans=$_POST['arr'];
			//$sel=$_POST['sel'];
		 for($i=1;$<=6;$i++){ 
		 $_SESSION['answers'][$i]=$ans[$i];
			 
		 }
//$_SESSION['correct'][$ind]=$ans;
       //echo $_SESSION['answers'][$ind]; 
//echo $_SESSION['correct'][$ind];
   
?>	 