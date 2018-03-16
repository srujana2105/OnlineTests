<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: FacultyLogin.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: FacultyLogin.php");
  }
?>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="Faculty.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<ul class="sidenav">
  	
    <?php  if (isset($_SESSION['username'])) : ?>
    	 <br><p style="margin:10%"><strong><?php echo $_SESSION['username']; ?><br>Faculty ID:</strong><?php echo $_SESSION['fid']; ?>
    <?php endif ?></p><br>
    <li><a class="active" href="#home">Home</a></li>
  <li><a href="#viewquestions">View questions</a></li>
  <li><a href="#results">View Responses and Results</a></li>
    <li><a href="FacultyLogin.php" target="_parent">Logout</a></li>
    </ul>
    <div id="home">
    
        <div class="content">Contests</div>
    
    </div>
    <div id="viewquestions">
    
    <div class="content">viewquestions</div>
    
    </div>
    <div id="results">
    
        <div class="content">Results</div>
    
    </div>
</body>
</html>