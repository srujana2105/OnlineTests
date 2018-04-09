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
    <link rel="stylesheet" type="text/css" href="ViewQuestions.css">
    <script type="text/javascript" src="jquery-3.3.1.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<ul class="sidenav" id="sidenav" style="margin-top:0px">
  	
    <?php  if (isset($_SESSION['username'])) : ?>
    	 <br><p style="margin:10%"><strong><?php echo $_SESSION['username']; ?><br>Faculty ID:</strong><?php echo $_SESSION['fid']; ?>
    <?php endif ?></p><br>

  
    <li ><a id="Home" class="active" onclick="Home()">Home</a></li>
    <li><a id="VQ" class="inactive" onclick="ViewQuestions()">View questions</a></li>
  <li><a id="Results"  class="inactive" onclick="Results()">View Responses and Results</a></li>
    <li><a href="FacultyLogin.php" target="_parent">Logout</a></li>

    </ul>
    <div id="content" align="center" style="margin-top:20px">
    
          
    </div>
    <script>
		onload=Home();

        var arrobj;
        function makeTableHTML(myArray) {
    var result = "<table border=1 id='table_detail' align=center cellpadding=10><tr><th>Question ID</th><th>Question</th><th>Option A</th><th>Option B</th><th>Option C</th><th>Option D</th><th>Answer</th><tr>";
    for(var i=0; i<myArray.length; i++) {
        result += "<tr>";
        for(var j=0; j<myArray[i].length; j++){
            result += "<td>"+myArray[i][j]+"</td>";
        }
        result += "<td><button onclick='show_hide_row("+i+");'>edit</button></td></tr><tr id='hidden_row"+i+"'  class='hidden_row'></tr>";
    }
    result += "</table>";

    return result;
}
        function confirmedit()
        {
            var r=confirm("Do you want to edit the selected question?");
        }
        function show_hide_row(i)
        {    
            row='hidden_row'+i;
            console.log(arrobj);
            document.getElementById(row).innerHTML="<td colspan=8><div><form id='editques"+arrobj[i][0]+"' method='POST' onsubmit='confirmedit();' action='EditQuestion.php'>      <input type='hidden' name='qid' form='editques"+arrobj[i][0]+"' value='"+arrobj[i][0]+"'><label>Question:</label>    <textarea form='editques"+arrobj[i][0]+"' name='question' rows='3' cols='70'>"+arrobj[i][1]+"</textarea>    <br><br>    <label>OpA</label><textarea  form='editques"+arrobj[i][0]+"' name='opa' rows='2' cols='70'>"+arrobj[i][2]+"</textarea><br><br>    <label>OpB</label><textarea  form='editques"+arrobj[i][0]+"' name='opb' rows='2' cols='70'>"+arrobj[i][3]+"</textarea><br><br>    <label>OpC</label> <textarea  form='editques"+arrobj[i][0]+"' name='opc' rows='2' cols='70'>"+arrobj[i][4]+"</textarea><br><br><label>OpD</label><textarea  form='editques"+arrobj[i][0]+"' name='opd' rows='2' cols='70'>"+arrobj[i][5]+"</textarea><br><br><label>Answer</label><textarea  form='editques"+arrobj[i][0]+"' name='answer' rows='2' cols='70'>"+arrobj[i][6]+"</textarea><br><br><button form='editques"+arrobj[i][0]+"' type='submit' name='edit'>Edit</button></form></div><td>";
            //alert(document.getElementById(row).innerHTML);
            $("#"+row).toggle();            
        }
        function ViewQuestions()  {
        
            document.getElementsByClassName("active")[0].className="inactive";

            var e=document.getElementById("VQ");
            e.className="active";
            
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {                  
                    arrobj=JSON.parse(ajx.responseText);
                    console.log(arrobj);
                    document.getElementById("content").innerHTML = makeTableHTML(arrobj);
                }
            };
            ajx.open("GET","ViewQuestions.php",true);
        ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx.send();
            
        }
    function Results()  {
		
		var conn="<input type='button' id='response' value='particular student response'><br/><input type='button' id='allstudres' value='all Students Results'>";
			
		document.getElementById("content").innerHTML = conn;
		
		document.getElementById("response").onclick=function(){ 
		var arrobj2;
		var con="Enter Roll no of student:<input type='text' id='roll'><div id='sub'><input type='button'  value='submit'></div>";
			
		document.getElementById("content").innerHTML = con;
		
        
        document.getElementsByClassName("active")[0].className="inactive";
            var e=document.getElementById("Results");
            e.className="active";
        
            document.getElementById('sub').onclick=function(){
				var id=document.getElementById('roll').value;
		window.alert(id);
			var ajx2 = new XMLHttpRequest();
            ajx2.onreadystatechange = function () {
                if (ajx2.readyState == 4 && ajx2.status == 200) {
				document.getElementById("content").innerHTML =ajx2.responseText;
//arrobj2=JSON.parse(ajx2.responseText);
                    console.log(arrobj2);
					//document.getElementById("content").innerHTML =arrobj2[1]['q1']+arrobj2[2]['q2'];
                   //result(arrobj2);
                }
            };
			var cred = "&id="+id;
            ajx2.open("POST","Results.php",true);
        ajx2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx2.send(cred);
			
			
			}
			
			
//			function result(x){
//				var score=0;
//        var tab="<table border='1'><tr><th>QID</th><th>Question</th><th>Student answer</th><th>Correct answer</th></tr>";
//			for(i=1;i<=6;i++)
//				{
//					if(x[i]['answer']==x[i]['correct']){
//						score++;
//					}
//					tab+="<tr><td>"+x[i]['QID']+"</td><td>"+x[i]['Question']+"</td><td>"+x[i]['answer']+"</td><td>"+x[i]['correct']+"</td> </tr>";
//				}
//			tab+="</table>";
//				tab+="the student Score is:"+score;
//			document.getElementById("content").innerHTML = tab;	
//
//		
//		}
			
//			function result(x){
//				var score=0;
//        var tab="<table border='1'><tr><th>Question</th><th>Student answer</th></tr>";
//			for(i=1;i<=6;i++)
//				{
////					if(x[i]['answer']==x[i]['correct']){
////						score++;
////					}
//					tab+="<tr><td>"+x[i]['q'+i]+"</td><td>"+x[i]['a'+i]+"</td> </tr>";
//				}
//			tab+="</table>";
//				tab+="<input type='button' value='back' id='back' >";
//				//tab+="the student Score is:"+score;
//				//window.alert(tab);
//			document.getElementById("content").innerHTML = tab;	
//
//		
//		}
		}
		document.getElementById("allstudres").onclick=function(){
			document.getElementById("content").innerHTML ="this is result page";
			var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
                    document.getElementById("content").innerHTML = ajx.responseText;
                }
            };
            ajx.open("POST","allstudres.php",true);
        ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx.send();

			
		}
			
		//document.getElementById("back").onclick=response();
        
          }
		
        function Home()  {

        document.getElementsByClassName("active")[0].className="inactive";
            var e=document.getElementById("Home");
            e.className="active";
			Hcon="<form><input type='button' value='add a contest'id='addcontest' ><br/><br /><input type='button' value='Remove a contest' id='remvcontest' ><br/><br /><input type='button' value='veiw all contests' id='viewcontests'</form>"
        document.getElementById("content").innerHTML=Hcon;
			
			document.getElementById("addcontest").onclick=function(){
				acon="<form><input type='text' id='name' placeholder='name of contest'><br /><input type='number' placeholder='no.of questions' id='noofque'><br /><select id='semester'><option value='1'>I</option><option value='2'>II</option><option value='3'>III</option><option value='4'>IV</option><option value='5'>V</option><option value='6'>VI</option><option value='7'>VII</option><option value='8'>VIII</option></select><br/><input type='button' id='create' value='create' onclick='Create()'></form>"
		document.getElementById("content").innerHTML=acon;
				
			}
			
			document.getElementById("remvcontest").onclick=function(){
					rcon="<form><input type='text' placeholder='contest to be removed' id='rname'><br/><input type='button' value='Remove contest' onclick='Remove()'></form>";
					
					document.getElementById("content").innerHTML=rcon;
				}
			
			
		document.getElementById("viewcontests").onclick=function(){
			window.alert("hello");
			
            var ajx3 = new XMLHttpRequest();
            ajx3.onreadystatechange = function () {
                if (ajx3.readyState == 4 && ajx3.status == 200) {
                    document.getElementById("content").innerHTML = ajx3.responseText;
                }
            };
            ajx3.open("POST","viewcontests.php",true);
        ajx3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx3.send();
		}
			
		
			
        
		}
		function Create(){
			window.alert('hello');
			var name=document.getElementById("name").value;
					var nq=document.getElementById("noofque").value;
					var sem=document.getElementById("semester").value;
					var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
                    document.getElementById("content").innerHTML = ajx.responseText;
                }
            };
				creds="&name="+name+"&nq="+nq+"&sem="+sem;
            ajx.open("POST","addcontest.php",true);
        ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx.send(creds);
		}
			function Remove(){
			window.alert('hello2');
			var rname=document.getElementById("rname").value;
			window.alert(rname);
			var ajx2 = new XMLHttpRequest();
            ajx2.onreadystatechange = function () {
                if (ajx2.readyState == 4 && ajx2.status == 200) {
                    document.getElementById("content").innerHTML = ajx2.responseText;
                }
            };
				creds="&rname="+rname;
            ajx2.open("POST","remvcontest.php",true);
        ajx2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx2.send(creds);
		}
		
		
		
    </script>

</body>
</html>