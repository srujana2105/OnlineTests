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
		
		
		include 'connection.php';
		
		//$answers=array();
       $_SESSION['answers']=array();
		for($j=1;$j<=6;$j++){
			$_SESSION['answers'][$j]=" ";
		}

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
<!--
	<?php  
	echo "testing".$_SESSION['answers'][1].$_SESSION['answers'][2].$_SESSION['answers'][3];
	?>
-->
	<script>
//		
		var pool;
		var ans=[];
		for(i=1;i<=6;i++)
		ans[i]=" ";
		//ans[]=" ";
		
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
		 var ajx4 = new XMLHttpRequest();
			  
            ajx4.onreadystatechange = function () {
                if (ajx4.readyState == 4 && ajx4.status == 200) {
					//window.alert("storing");
					console.log("haii1");
					document.getElementById("profile").innerHTML=ajx4.responseText;

					//window.alert("success");
                    console.log("haii2");
				}
			};
			   var p="&pool="+pool;
            ajx4.open("POST","pool.php",true);
        ajx4.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx4.send(p);

		
		

		document.getElementById('instructions').innerHTML="<h1>HI</h1>";
		var n=6;
		var attempt=[];
		//attempt[]=0;
		var cor=[];
		//cor[]=0;
		  function disp(row){ 
	 // window.alert("row");
	display(0,row);	
			  var x=0;
	document.getElementById("next").onclick = function(){
           
            if( x==n-1 )
            {
                document.getElementsByName("next").disabled = true;
//                document.getElementsByName("submit").style.display=block;                
            }
        else {display(x+1,row); x=x+1;}
        }
            document.getElementById("prev").onclick = function(){if( x==0 )
            {
                document.getElementsByName("previous").disabled = true;
            }
        else {
            display(x-1,row); x=x-1;
        }                                                    
        }
			
			
}
		function display(x,row){
			
			var y=pool[x]+1;
			//window.alert("display");
			
			//ans[x]=row[x]["Answer"];
			//window.alert(ans[x]);
			
			//var question= '<div class="options">'+x+'.'+row[x]["Question"]+'.</div><hr><br>  <form><div class="options"> <input type="radio" name="answer" id="op1" value="'+row[x]["OpA"]+'"  onchange="func(this.value,'+x+')" >a.'+row[x]["OpA"]+'</div>   <br><br><div class="options"><input type="radio" name="answer" id="op2" value="'+row[x]["OpB"]+'" onchange="func(this.value,'+x+')" >b.'+row[x]["OpB"]+'.</div><br><br><div class="options"><input type="radio" name="answer" id="op3" value="'+row[x]["OpC"]+'" onchange="func(this.value,'+x+')" >c.'+row[x]["OpC"]+'.</div><br><br><div class="options"><input type="radio" name="answer" id="op4" value="'+row[x]["OpD"]+'" onchange="func(this.value,'+x+')" >d.'+row[x]["OpD"]+'.</div></form>';
			var qno=x+1;
			ans[y]=" ";
			var question= '<div class="options">'+qno+'.'+row[y]["Question"]+'.</div><hr><br>  <form><div class="options"> <input type="radio" name="answer" id="op1" value="'+row[y]["OpA"]+'"  onchange="func(this.value,'+y+')" >a.'+row[y]["OpA"]+'</div>   <br><br><div class="options"><input type="radio" name="answer" id="op2" value="'+row[y]["OpB"]+'" onchange="func(this.value,'+x+')" >b.'+row[y]["OpB"]+'.</div><br><br><div class="options"><input type="radio" name="answer" id="op3" value="'+row[y]["OpC"]+'" onchange="func(this.value,'+y+')" >c.'+row[y]["OpC"]+'.</div><br><br><div class="options"><input type="radio" name="answer" id="op4" value="'+row[y]["OpD"]+'" onchange="func(this.value,'+y+')" >d.'+row[y]["OpD"]+'.</div></form>';

					document.getElementById('instructions').innerHTML=question;
			if(attempt[x]==1){
document.getElementById("op"+cor[x]).checked="checked";
			}

		}


			function func(y,i)
    {
		
//	var ans2=ans;
//		var ind2=ind;
		var t=1;
       for(t=1;t<=4;t++)
		   {
			   if(document.getElementById("op"+t).value == y)
				   { 
					   //window.alert("checking");
					   attempt[i]=1;
					   cor[i]=t;
//					   window.alert(attempt[i]);
//					   window.alert(cor[i]);
					   
				   }
			   
		   }
		
		ans[i]=y;
		
//		 
		
	
	//	window.alert(answer.length);
    }
		
	document.getElementById("submit").onclick= function()
	{
		window.alert("submit");
		
		var ajx2 = new XMLHttpRequest();
			  
            ajx2.onreadystatechange = function () {
                if (ajx2.readyState == 4 && ajx2.status == 200) {
					//window.alert("storing");
					//console.log("haii1");
					alert(ans);
					//document.getElementById("result").innerHTML=ajx2.responseText;
document.getElementById("score").innerHTML=ajx2.responseText;
					//window.alert("success");
                    //console.log("haii2");
				}
			};
			   var credss = "&ans="+ans;
            ajx2.open("POST","score.php",true);
        ajx2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx2.send(credss);

		
		
//		var ajx3= new XMLHttpRequest();
//				ajx3.onreadystatechange = function (){ 
//				if(ajx3.readyState == 4 && ajx3.status == 200){
//					document.getElementById("score").innerHTML=ajx3.responseText;
//				}
//				};
//				//var creds = "sql="+sql+"&ind="+x;
//            ajx3.open("POST","score.php",true);
//        ajx3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//            ajx3.send();
//		
	}
	var sql = "SELECT * FROM testdb.questions";
        
            var ajx = new XMLHttpRequest();
			  
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
					row=JSON.parse(ajx.responseText);
				console.log(row[1]["Question"]);
					document.getElementById("instructions").innerHTML=ajx.responseText;
					disp(row);
				}
			};
		var creds = "sql="+sql;
            ajx.open("POST","question.php",true);
        ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx.send(creds);
		
	
	</script>
	</body>
</html>