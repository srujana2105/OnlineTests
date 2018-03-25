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
    <li><a class="active"  id= "home" href="#home">Home</a></li>
  <li><a href="#viewquestions" id="VQ">View questions</a></li>
  <li><a href="#results" id="Results">View Responses and Results</a></li>
    <li><a href="FacultyLogin.php" target="_parent" >Logout</a></li>
    </ul>
    <div id="content">
    
          
    </div>
    <script>
        function ViewQuestions()  {
        
            document.getElementsByClassName("active").className="inactive";
            var e=document.getElementById("VQ");
            e.className="active";
            
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
                    document.getElementById("content").innerHTML = ajx.responseText;
                }
            };
            ajx.open("POST","viewquestions.php",true);
        ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx.send();
        
          }
    function Results()  {
        
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
                    document.getElementById("content").innerHTML = ajx.responseText;
                }
            };
            ajx.open("POST","Results.php",true);
        ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx.send();
        
          }
        function Home()  {
        
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
                    document.getElementById("content").innerHTML = ajx.responseText;
                }
            };
            ajx.open("POST","Home.php",true);
        ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx.send();
        
          }
    </script>

</body>
</html>