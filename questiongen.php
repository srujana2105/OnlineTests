<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Test screen</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
    <div id="bluebar"></div>
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
    <?php endif ?></div>
    <div id="greenbar" ></div>
    <div id="instructions">hi </div>
            
    <div><div id="prev" style="position: fixed; bottom: 50px;" ><button name="previous" style="float: left;">Previous</button>
        </div><div id="next" style="position: fixed; bottom: 50px; right: 400px;"><button name="next" style="float: right;">Next</button>
        </div>	
       
        </div>
    
    <script type= "text/javascript" >  
        var pool;
        var n = 5;
        pool = Array.apply(null, Array(n)).map(function (_, i) {return i;});
        var x=1;
        function shuffle(array) {
          var currentIndex = array.length, temporaryValue, randomIndex;

          // While there remain elements to shuffle...
          while (0 !== currentIndex) {

            // Pick a remaining element...
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;

            // And swap it with the current element.
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
              }

              return array;
            }
        pool=shuffle(pool);
        document.getElementById('profile').innerHTML=pool;
    console.log(pool);
        
            document.getElementById('instructions').innerHTML="<h1>HI</h1>";
        display(0);
        document.getElementById("next").onclick = function(){
            if( x==n-1 )
            {
                document.getElementsByName("previous").disabled = true;
            }
        else {display(x+1); x=x+1;}
        }
            document.getElementById("prev").onclick = function(){if( x==0 )
            {
                document.getElementsByName("previous").disabled = true;
            }
        else {
            display(x-1); x=x-1;
        }                                                    
        }
          function display(x)  {
        var sql = "SELECT * FROM questions WHERE QID="+(pool[x]+1);
        
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
                    document.getElementById("instructions").innerHTML = ajx.responseText;
                }
            };
            var creds = "sql="+sql+"&ind="+x;
            ajx.open("POST","question.php",true);
        ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx.send(creds);
        
          }
    </script>
    
</body>
</html>