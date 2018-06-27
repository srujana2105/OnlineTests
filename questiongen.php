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
        $answers=array();
        $_SESSION['answers'];
       $correct=array();
        $_SESSION['correct'];
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
    <div id="instructions">hi Hello </div>
	<div id="result">Result: </div>
	<div id="score">your Score is </div>
            
    <div><div id="prev" style="position: fixed; bottom: 50px;" ><button name="previous" style="float: left;">Previous</button>
        </div><div id="next" style="position: fixed; bottom: 50px; right: 400px;"><button name="next" style="float: right;">Next</button></div>
        <div id="submit" style="position: fixed; bottom: 50px; right: 500px;"><button name="submit" style="float: center; ">submit</button>
		</div></div>	
       
        
    
    <script type= "text/javascript" >  
        var x=1;
		var row;
		var pool;
		
        var n = 6;
        pool = Array.apply(null, Array(n)).map(function (_, i) {return i;});
        
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
                document.getElementsByName("next").disabled = true;
//                document.getElementsByName("submit").style.display=block;                
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
			document.getElementById("submit").onclick = function(){
			  window.alert("Hello");
				var ajx3= new XMLHttpRequest();
				ajx3.onreadystatechange = function (){ 
				if(ajx3.readyState == 4 && ajx3.status == 200){
					document.getElementById("score").innerHTML=ajx3.responseText;
				}
				};
				//var creds = "sql="+sql+"&ind="+x;
            ajx3.open("POST","score.php",true);
        ajx3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx3.send();
			}
          function display(x)  {
        var sql = "SELECT * FROM questions WHERE QID="+(pool[x]+1);
        
            var ajx = new XMLHttpRequest();
			  
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
//					var r=ajx.responseText;
//					console.log(r);
//					var x='{"QID":"3","Question":"What is our national bird?","OpA":"Parrot","OpB":"Peacock","OpC":"Pigeon","OpD":"Sparrow","Answer":"Peacock"}';
			     row=JSON.parse(ajx.responseText);
				console.log(row["Question"]);
          //document.getElementById("instructions").innerHTML = question(row,x);
					var ind=x+1;
					var ans=String(row["Answer"]);
					window.alert(ans);
					console.log(ans+ind);
					var question= '<div class="options">'+x+'.'+row["Question"]+'.</div><hr><br>  <form><div class="options"> <input type="radio" name="answer" id="op1" value="'+row["OpA"]+'"  onchange="func(this.value,'+x+')" checked="checked" >a.'+row["OpA"]+'</div>   <br><br><div class="options"><input type="radio" name="answer" id="op2" value="'+row["OpB"]+'" onchange="func(this.value,'+x+')" >b.'+row["OpB"]+'.</div><br><br><div class="options"><input type="radio" name="answer" id="op3" value="'+row["OpC"]+'" onchange="func(this.value,'+x+')" >c.'+row["OpC"]+'.</div><br><br><div class="options"><input type="radio" name="answer" id="op4" value="'+row["OpD"]+'" onchange="func(this.value,'+ind+')" >d.'+row["OpD"]+'.</div></form>';
					document.getElementById("instructions").innerHTML=question;
					
                }
            };
            var creds = "sql="+sql+"&ind="+x;
            ajx.open("POST","question.php",true);
        ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx.send(creds);
		  
		  }

		function func(y,a,i)
    {
		
//	var ans2=ans;
//		var ind2=ind;
//       for(i=1;i<=4;i++)
//		   {
//			   if(document.getElementById("op"+i).value == y)
//				   { 
//					   window.alert("checking");
//					   document.getElementById("op"+i).checked="checked";
//				   }
//			   else{
//				   document.getElementById("op"+i).checked="unchecked";
//			   }
//		   }
		 var ajx2 = new XMLHttpRequest();
			  
            ajx2.onreadystatechange = function () {
                if (ajx2.readyState == 4 && ajx2.status == 200) {
					//window.alert("storing");
					console.log("haii1");
					document.getElementById("result").innerHTML=ajx2.responseText;

					window.alert("success");
                    console.log("haii2");
				}
			};
			   var credss = "&ans="+a+"&ind="+i+"&sel="+y;
            ajx2.open("POST","result.php",true);
        ajx2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx2.send(credss);

		
		window.alert(x);
	//	window.alert(answer.length);
    }
        window.alert("hello");
            </script>
    
</body>
</html>