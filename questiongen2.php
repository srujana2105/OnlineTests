<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Test screen</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<style>
/*
		#ques{
			float: right;
			background-color: aliceblue;
			border: 2px,black,solid;
			width:230px;
			height: auto;
			padding: 10px;
			margin-top: 70px;
			margin-right: 50px;
			
		}
*/
		.btns{
			//width:20px;
			color:black;
			background-color:white;
			padding-left: 10px;
			padding-right: 10px;
			//margin-left: 10px;
			margin: 5px;
		}
		#hms{
			float:right;
			font-size: 20px;
			width:auto;
			background-color:aliceblue;
			border-radius: 5px;
		}
		.view{
			background-color:aliceblue;
			width: 230px;
			height: auto;
			padding: 10px;
			margin-top: 70px;
			margin-right: 50px;
			float: right;
		}
		#cont{
			font-family: bold;
			font-size: 30px;
			color: aliceblue;
		}
	
	</style>
	
</head>
<body>
    <div id="bluebar"></div>
    <div id="profile">
    <?php 
  session_start(); 
		
		
		include 'connection.php';
		//$cont=$_POST['cont'];
		//$answers=array();
       $_SESSION['answers']=array();
		for($j=1;$j<=10;$j++){
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
    <div id="greenbar" >
		<div><span id="cont"><?php echo $_SESSION['cont']; ?></span>
		<span ><button id=hms><?php echo $_SESSION['dn'];?>:00</button></span></div>
	</div>
    <div id="instructions">hi Hello </div>
	
	<div align="right" class="view" id="ques">You can view your questions here<br></div>
	<div align="right" class="view"><div>
		notvisited:<span id="nv"></span>
		</div>
	<div >Visited:<span id="vi"></span></div>
	<div >Not Answered:<span id="na"></span></div>
		<div >Answered:</div><span id="a"></span>
	<div >Mark for review:</div><span id="mr"></span></div>
            
    <div><div id="prev" style="position: fixed; bottom: 50px;" ><button name="previous">Previous</button>
        </div>
		<div id="mark" style="position: fixed; bottom: 50px; left: 200px;" ><button name="Mark">Mark for Review</button>
        </div><div id="next" style="position: fixed; bottom: 50px; right: 400px;"><button name="next" style="float: right;">Next</button></div>
        <div id="submit" style="position: fixed; bottom: 50px; right: 500px;"><button name="submit" style="float: center; ">submit</button>
		</div></div>
	
	
<!--
	<?php  
	echo "testing".$_SESSION['answers'][1].$_SESSION['answers'][2].$_SESSION['answers'][3];
	?>
-->
	<script>
		console.log("welcome");
		alert("welcome");
		var d=<?php echo $_SESSION['dn']; ?>;
onload=countdown(d);
		
		var timeoutHandle;
function countdown(minutes) {
    var seconds = 60;
    var mins = minutes
    function tick() {
        var counter = document.getElementById("hms");
        var current_minutes = mins-1
        seconds--;
        counter.innerHTML = current_minutes.toString() + ":" + (seconds < 10 ? "0" : "") + String(seconds);
        if( seconds > 0 ) {
            timeoutHandle=setTimeout(tick, 1000);
        } else {

            if(mins > 1){
               setTimeout(function () { countdown(mins - 1); }, 1000);

            }else{
				alert("test completed");
				submit2();
			}
        }
    }
    tick();
}

		var p=<?php echo $_SESSION['nq']; ?>;
		//console.log(p);
		var n=Number(p);
		//console.log(p2);
		var pool;
		var ans=[];
		var view=[];
		var mark=[];
		for(i=1;i<=n;i++){
			view[i]=0;
			ans[i]=" ";
		}
		
		var str=" ";
		var row;
		
		for(var t=1;t<=p;t++){
			str +='<button id="btn'+t+'" class="btns" onclick="ques('+t+')">'+t+'</button>';
				
		}
		//window.alert(str);
document.getElementById("ques").innerHTML +=str;
		
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
      //  document.getElementById('profile').innerHTML=pool;
    console.log(pool);
		 var ajx4 = new XMLHttpRequest();
			  
            ajx4.onreadystatechange = function () {
                if (ajx4.readyState == 4 && ajx4.status == 200) {
					//window.alert("storing");
					//console.log("haii1");
					//document.getElementById("profile").innerHTML=ajx4.responseText;

					//window.alert("success");
                 //   console.log("haii2");
				}
			};
			   var p="&pool="+pool;
            ajx4.open("POST","pool.php",true);
        ajx4.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx4.send(p);

		
		

		document.getElementById('instructions').innerHTML="<h1>HI</h1>";
		//var n=10;
		var attempt=[];
		//attempt[]=0;
		var cor=[];
		//cor[]=0;
		var x=0;
		var mr=0;
		var vi=0;
		var nv=n;
		var na=0;
		var a=0;
		  function disp(row){ 
	display(0,row);	
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
		function ques(t){
			//x=t-1;
   display(t-1,row);
			x=t-1;
		}
		
		function display(x1,row){
			
			var y=pool[x1]+1;
			//var view[]=0;
			var qno=x1+1;
			//view[y]=1;
			ans[y]=" ";
			var question= '<div class="options">'+qno+'.'+row[y]["Question"]+'.</div><hr><br>  <form><div class="options"> <input type="checkbox" name="answer" id="op1" value="'+row[y]["OpA"]+'"  onchange="func(this.value,'+y+','+qno+')" >a.'+row[y]["OpA"]+'</div>   <br><br><div class="options"><input type="checkbox" name="answer" id="op2" value="'+row[y]["OpB"]+'" onchange="func(this.value,'+y+','+qno+')" >b.'+row[y]["OpB"]+'.</div><br><br><div class="options"><input type="checkbox" name="answer" id="op3" value="'+row[y]["OpC"]+'" onchange="func(this.value,'+y+','+qno+')" >c.'+row[y]["OpC"]+'.</div><br><br><div class="options"><input type="checkbox" name="answer" id="op4" value="'+row[y]["OpD"]+'" onchange="func(this.value,'+y+','+qno+')" >d.'+row[y]["OpD"]+'.</div></form>';

					document.getElementById('instructions').innerHTML=question;

			if(view[y]==0){
				vi=vi+1;
				document.getElementById("vi").innerHTML = vi;

				nv=nv-1;
				document.getElementById("nv").innerHTML = nv;
			}else{
				
			}
			view[y]=1;
			if(attempt[y]==1){
document.getElementById("op"+cor[y]).checked="checked";

			}else{
				if(view[y]==1){
					document.getElementById("btn"+qno).style.backgroundColor="red";
                  
				}
			}
			
		document.getElementById("mark").onclick = function(){
				if(attempt[y]==1){
					if(mark[y]==1){
						
						window.alert("already marked");
						mark[y]=0;
                   mr=mr-1;			
						document.getElementById("mr").innerHTML = mr;
				document.getElementById("btn"+qno).style.backgroundColor="green";
			}else{ 
					window.alert("attempted");
					document.getElementById("btn"+qno).style.backgroundColor="blue";
			mr=mr+1;
				document.getElementById("mr").innerHTML = mr;
					mark[y]=1;
			         
				window.alert("no. of marked");
			}
				}
			
				
			}
		document.getElementById("vi").innerHTML = vi;
			document.getElementById("nv").innerHTML = nv;
			document.getElementById("mr").innerHTML = mr;
			document.getElementById("na").innerHTML = vi-a-1;
          document.getElementById("a").innerHTML = a;

		}


			function func(x2,i,q)
		
    { 
		window.alert(ans[i]);
		if(ans[i] == x2){
			ans[i]=' ';
			console.log(ans[i]);
			//window.alert("second click");
			document.getElementById("op"+cor[i]).checked=false;
			a=a-1;
			document.getElementById("a").innerHTML = a;
		}
		else{
			window.alert("clicked");
			document.getElementById("btn"+q).style.backgroundColor="green";
			a=a+1;
			document.getElementById("a").innerHTML = a;
		attempt[i]=0;
		mark[i]=0;
		var t=1;
       for(t=1;t<=4;t++)
		   {
			   //document.getElementById("btn"+i).style.background-color="green";
				   if(document.getElementById("op"+t).value == x2)
				   { 
		
					   attempt[i]=1;
					   cor[i]=t;
	   
				   }
			   
		   }
			for(t=1;t<=4;t++){
				if(cor[i]==t){
					document.getElementById("op"+t).checked=true;
				}else
					document.getElementById("op"+t).checked=false;
			}
		
		ans[i]=x2;
		if(attempt[i]==0){
		document.getElementById("btn"+q).style.backgroundColor="red";
//			na=na+1;
//			document.getElementById("na").innerHTML = na;
		}
//		document.getElementById("mark").onclick = function(){
//				window.alert("mark clicked");
//				if(attempt[i]==1){
//					if(mark[i]==1){
//						window.alert("already marked");
//						mark[i]=0;
//						mr=mr-1;
//				document.getElementById("btn"+q).style.backgroundColor="green";
//			}else{ 
//					window.alert("attempted");
//					document.getElementById("btn"+q).style.backgroundColor="blue";
//					mark[i]=1;
//				mr=mr+1;
//			}
//				}
//			
//				
//			}	
		}

    }
		
			
	document.getElementById("submit").onclick= function()
	{
		
		var r=confirm("are you sure you want to submit");
	if(r){
//			  var ajx2=new XMLHttpRequest();
//            ajx2.onreadystatechange = function () {
//                if (ajx2.readyState == 4 && ajx2.status == 200) {
//					alert(ans);
//		
//						var myWindow = window.open(" ","_self");
//					alert(myWindow);
//myWindow.document.write(ajx2.responseText);
//						
//						//window.location="main.php";
//				}
//					
//			};
//			   var credss = "&ans="+ans;
//            ajx2.open("POST","score.php",true);
//        ajx2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//            ajx2.send(credss);
}
		submit2();
	}
	var sql = "SELECT * FROM testdb.q<?php echo $_SESSION['cont'] ?>";
        
            var ajx = new XMLHttpRequest();
			  
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
					
					row=JSON.parse(ajx.responseText);
					document.getElementById("instructions").innerHTML=ajx.responseText;
					disp(row);
				}
			};
		var creds = "sql="+sql;
            ajx.open("POST","question.php",true);
        ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx.send(creds);
		
	function submit2(){
		  var ajx2=new XMLHttpRequest();
            ajx2.onreadystatechange = function () {
                if (ajx2.readyState == 4 && ajx2.status == 200) {
					
		
						var myWindow = window.open(" ","_self");
					
myWindow.document.write(ajx2.responseText);
						
		
				}
					
			};
			   var credss = "&ans="+ans;
            ajx2.open("POST","score.php",true);
        ajx2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx2.send(credss);
	
	}
		
	</script>
	</body>
</html>