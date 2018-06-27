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
  session_start(); 

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
	<br />
<div id="Contests" >
	
Hello 
    

    <span align="left"><h1>Contests Available</h1></span>

<div align="right">
   <form method="post" action="main.php"
		 target="_blank"> <button name="Ready"  id="ready" type="submit">Ready</button></form></div></div>
<!--
    <script>
	document.getElementById("ready").onclick=function(){
header('location: main2.php');
	}
	</script>
-->
<script>
	
	onload=loadcontests();
	
	function loadcontests(){
		
		var ajx2 = new XMLHttpRequest();
            ajx2.onreadystatechange = function () {
                if (ajx2.readyState == 4 && ajx2.status == 200) {
				window.alert("hello");
			document.getElementById("Contests").innerHTML +=ajx2.responseText;
				console.log(ajx2.responseText);
					
//arrobj2=JSON.parse(ajx2.responseText);
                    //console.log(arrobj2);
				console.log("success loaded");	//document.getElementById("content").innerHTML =arrobj2[1]['q1']+arrobj2[2]['q2'];
                   //result(arrobj2);
                }
            };
			//var cred = "&id="+id;
            ajx2.open("POST","loadcontests.php",true);
        ajx2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx2.send();
	}
	
	</script>		
</body>
</html>