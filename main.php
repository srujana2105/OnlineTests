<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
    <div id="bluebar" ></div>
    <div id="profile">
    <?php 
		include 'connection.php';
  session_start(); 
		$cont=$_POST['cont'];
		$_SESSION['cont']=$cont;
		//$_SESSION['nq']=0;
		$r=0;
		echo "hello ".$_SESSION['cont']." test";
$q="select noofque from testdb.contests where ContestName='".$_SESSION['cont']."'";
		$n=$con->query($q) or die($con->error);
	
		while($r=$n->fetch_assoc()){
			$_SESSION['nq']=$r['noofque'];
    }
		echo $_SESSION['nq'];
		
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: index.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: index.php");
  }
?>
    <?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?><br>Roll No.:</strong><?php echo $_SESSION['rollno']; ?></p>
    	<p> <a href="index.php?logout='1'" style="color: red;" target="_parent">logout</a> </p>
    <?php endif ?></div>
    <div id="greenbar" ></div>
<div id="instructions">

    <h1>Contest Name: <?php echo $cont; ?></h1>
	<br>
	Please read the instructions carefully

    <span><h2>General Instructions:</h2></span>

Total duration of examination is 150 minutes.
The clock will be set at the server. The countdown timer in the top right corner of screen will display the remaining time available for you to complete the examination. When the timer reaches zero, the examination will end by itself. You will not be required to end or submit your examination.
The Question Palette displayed on the right side of screen will show the status of each question using one of the following symbols:
1	You have not visited the question yet.
3	You have not answered the question.
5	You have answered the question.
7	You have NOT answered the question, but have marked the question for review.
9	You have answered the question, but marked it for review.
The Marked for Review status for a question simply indicates that you would like to look at that question again.
You can click on the ">" arrow which appears to the left of question palette to collapse the question palette thereby maximizing the question window. To view the question palette again, you can click on  which appears on the right side of question window.

Navigating to a Question:
To answer a question, do the following:
Click on the question number in the Question Palette at the right of your screen to go to that numbered question directly. Note that using this option does NOT save your answer to the current question.
Click on Save & Next to save your answer for the current question and then go to the next question.
Click on Mark for Review & Next to save your answer for the current question, mark it for review, and then go to the next question.

Answering a Question :

Procedure for answering a multiple choice type question:
To select your answer, click on the button of one of the options
To deselect your chosen answer, click on the button of the chosen option again or click on the Clear Response button
To change your chosen answer, click on the button of another option
To save your answer, you MUST click on the Save & Next button
To mark the question for review, click on the Mark for Review & Next button.
To change your answer to a question that has already been answered, first select that question for answering and then follow the procedure for answering that type of question.

Navigating through sections:

Sections in this question paper are displayed on the top bar of the screen. Questions in a section can be viewed by clicking on the section name. The section you are currently viewing is highlighted.
After clicking the Save & Next button on the last question for a section, you will automatically be taken to the first question of the next section.
You can shuffle between sections and questions anytime during the examination as per your convenience only during the time stipulated.
Candidate can view the corresponding section summary as part of the legend that appears in every section above the question palette.<br><br><div align="right">
   <form method="post" action="questiongen2.php" target="question"> <button name="ok" type="submit">OK</button></form></div></div>
    
		
</body>
</html>