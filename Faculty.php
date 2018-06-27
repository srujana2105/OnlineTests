<?php 
  session_start(); 
include 'connection.php';
$resultsPerPage=5;
$page_limit=0;

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
    <li><a id="AddQuestion" class="inactive" onclick="AddQuestion()">Add question</a></li>
  <li><a id="Results"  class="inactive" onclick="Results()">View Responses and Results</a></li>
    <li><a id="VS" class="inactive" onclick="ViewSubjects()">View Subjects</a></li>
    <li><a href="FacultyLogin.php" target="_parent">Logout</a></li>

    </ul>
    <div id="content" align="center" style="margin-top:20px">
    
          
    </div>
    <script>

		onload=Home();
        var arrobj=[];
        var Arrobj;
        var subj;
        var str='';
        var str1='';
        var VQstr;
        var r=0;
        var sub;
        var rpp=2;

        function makeTableHTML(myArray) {
    var result='';
            console.log(myArray);
    for(var k=0; k<myArray.length; k++,r++) {
        result += "<tr>";
        for(var j=0; j<myArray[k].length; j++){
            result += "<td>"+myArray[k][j]+"</td>";
        }
       // result+="<td"+subj[i][]
       // console.log(r);
        arrobj.push(myArray[k]);
        result += "<td><button onclick='show_hide_row("+(r)+")'>edit</button></td><td><button onclick='removequestion("+(r)+")'>Remove</button></td></tr><tr id='hidden_row"+(r)+"'  class='hidden_row'></tr>";
    }
    
            
          //  console.log(arrobj);
    return result;
}
        
        function getSubjects() {
        
            $.ajax({url: "getSubjects.php", type:"post" , success: function(result){subj=JSON.parse(result);}, async: false
    });
        }
        
        getSubjects();
        
        function removequestion(j) {
            
            var r=confirm ("Do you want to remove the selected question?")
            if(r)
                {
                   $.ajax({url: "RemoveQuestion.php", type:"post" , data: {qid: arrobj[j][0]}, success: function(result){
        alert(result);
                   }});
    
                }
        }
        
        function removeSubject(j)
        {
            
            var r=confirm ("Do you want to remove the selected subject?")
            if(r)
                {
                   $.ajax({url: "RemoveSubject.php", type:"post" , data: {sub: subj[j][0]}, success: function(result){
        alert(result);
        ViewSubjects();},async: false
                   });
    
                }
            
        }
        
        function ViewSubjects() {
                   // console.log(subj);
            getSubjects();
            console.log(subj);
            str1="<div style='position:fixed;margin-rigth:5%;margin-left:50%;'><input id='addsub' type='text' size=30><button onclick='addSubject()'>Add subject</button></div><br><br><br><table border=0 style='width:500px;font-size:20px;text-align:center;' align=center><tr><th>Subject</th><th>No. of questions</th>";
            for(var i=0;i<subj.length;i++)
                {
                    str1+="<tr><td>"+subj[i][1]+"</td><td>"+subj[i][2]+"</td><td><button onclick='show_hide("+i+")'>edit</button></td><td><button onclick='removeSubject("+i+")'>remove</button></td></tr><tr id='hidden_row"+(i)+"'></tr>";
                    //$("#hidden_row"+i).toggle();
                }
            str+="</table>";
            console.log(str1);
            $('#content').html(str1);
            
        }
        function show_hide(j)
        {
            $("#hidden_row"+j).html("enter new subject name:<input type='text' size=30 id='newsubname"+j+"'><button onclick='editsubj("+j+")'>Change</button>");
            $("#hidden_row"+j).toggle();
        }
        
        function editsubj(j)
        {
            newname=$("#newsubname"+j);
            alert(newname.value);
            var c=confirm(newname+"Do you want to edit the selected subject name?");
            if(c)
                {
                    $.ajax({url: "EditSubjectName.php", type:"post" , data: {sub: subj[j][0],name:newname}, success: function(result){
        alert(result);
        ViewSubjects();},async: false
                   });
                }
        }
        
        function addSubject()
        {
           var sub=document.getElementById('addsub').value;
            $.ajax({url: "AddSubject.php", type:"post" , data: {subject: sub}, success: ViewSubjects,async: false});
                
        }
        
        function edit(j)
        {
           var x= document.getElementById('editques'+arrobj[j][0]);
            if((x.question.value.trim()=='')||(x.answer.value.trim() == '')||(x.opa.value.trim() == '')||(x.opb.value.trim() == '')||(x.opc.value.trim() == '')||(x.opd.value.trim() == '')) {
            alert("fill all the textfields");
            return;
            }
            // {   alert("enter question");  }
            var c=confirm("Do you want to edit the selected question?");
            if(c)
                {
                    var a=$('#editques'+arrobj[j][0]).serialize();
                    //alert(a);
                    var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
                    alert(ajx.responseText);
                    ViewQuestions();
                }
            };
            ajx.open("POST","EditQuestion.php",true);
        ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx.send(a);
                }
                
        }
       /* var aj = new XMLHttpRequest();
            aj.onreadystatechange = function () {
                if (aj.readyState == 4 && aj.status == 200) {
                subj=JSON.parse(aj.responseText);
                    console.log(subj);            
                }
            };
            aj.open("POST","ListSubjects.php",true);
        aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            aj.send();*/
        
        function show_hide_row(i)
        {    
            row='hidden_row'+i;
            console.log(row);
            str="<td colspan=8><div><form id='editques"+arrobj[i][0]+"'>      <input type='hidden' name='qid' form='editques"+arrobj[i][0]+"' value='"+arrobj[i][0]+"'><label>Question:</label>    <textarea form='editques"+arrobj[i][0]+"' name='question' rows='3' cols='70'>"+arrobj[i][1]+"</textarea>    <br><br>    <label>OpA</label><textarea  form='editques"+arrobj[i][0]+"' name='opa' rows='2' cols='70'>"+arrobj[i][2]+"</textarea><br><br>    <label>OpB</label><textarea  form='editques"+arrobj[i][0]+"' name='opb' rows='2' cols='70'>"+arrobj[i][3]+"</textarea><br><br>    <label>OpC</label> <textarea  form='editques"+arrobj[i][0]+"' name='opc' rows='2' cols='70'>"+arrobj[i][4]+"</textarea><br><br><label>OpD</label><textarea  form='editques"+arrobj[i][0]+"' name='opd' rows='2' cols='70'>"+arrobj[i][5]+"</textarea><br><br><label>Answer</label><textarea  form='editques"+arrobj[i][0]+"' name='answer' rows='2' cols='70'>"+arrobj[i][6]+"</textarea><br><br><select name='subject'>"+dispsubj(subj)+"</select><input form='editques"+arrobj[i][0]+"' type='button' onclick='edit("+i+")' value='Edit'></form></div><td>";
            document.getElementById(row).innerHTML=str; //alert(document.getElementById(row).innerHTML);
            $("#"+row).toggle();            
        }
        

           // document.getElementsByClassName("active")[0].className="inactive";//


        
        function ViewQuestions()  {
			console.log("view Questions");
            arrobj=[];
            VQstr="<div id='filter' style='position:fixed;'><label>Subject</label><select name='subject'><option value='undefined'>All</option>"+dispsubj(subj)+"</select><button onclick='applyfilter()'>Apply</button></div><br><br>";
            str1='';
            r=0;
            page=1;
           $('#content').html(''); document.getElementsByClassName("active")[0].className="inactive";

            var e=document.getElementById("VQ");
            e.className="active";
        VQstr+= "<table border=1 id='table_detail' align=center cellpadding=10><tr><th>Question ID</th><th>Question</th><th>Option A</th><th>Option B</th><th>Option C</th><th>Option D</th><th>Answer</th><th>Subject</th></tr>";
           // alert(VQstr);
            loadmore();
        }
        function applyfilter()
        {
         sub=document.getElementById('filter').getElementsByTagName("select")[0].value;
            
            ViewQuestions();}
        
        
        function loadmore() {
            
                var ajx = new XMLHttpRequest();
                ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
                    Arrobj=(ajx.responseText);
                    load(Arrobj);
            };
                }
                ajx.open("POST","LoadMore.php",true);
        ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            cred="page="+page;
                cred+="&sub="+sub;
            ajx.send(cred);
            
        
            }
        function load(Arrobj) {
           // alert(Arrobj);
           // alert(makeTableHTML(JSON.parse(Arrobj)));
            var parsedarray=JSON.parse(Arrobj);
                    str1+= makeTableHTML(parsedarray);
                var nstr=str1+"</table>";
           // console.log(nstr);
               //alert(document.getElementById("content").innerHTML); 
                
                if(parsedarray.length == rpp){
            nstr=nstr+"<button onclick='loadmore()'>Load More</button>";
                }document.getElementById("content").innerHTML =VQstr+nstr;
                   // alert(nstr);
               page++; //document.getElementById("content").innerHTML+= "</table>";
                
            
        }
        function AddQuestion() {
            
           var x; document.getElementsByClassName("active")[0].className="inactive";
            var e=document.getElementById("AddQuestion");
            e.className="active"; 
            str="<form id='addQuestionForm'><br><label>Question:</label><textarea name='Question'></textarea><br><label>Option A:</label><textarea name='OpA'></textarea><br><label>Option B:</label><textarea name='OpB'></textarea><br><label>Option C:</label><textarea name='OpC'></textarea><br><label>Option D:</label><textarea name='OpD'></textarea><br><label>Answer:</label><textarea name='Answer'></textarea><br><label>Subject:</label><select name='Subject'>"+dispsubj(subj)+"</select><br><br><input type='button' onclick='add()' value='Add'></form>"; document.getElementById("content").innerHTML=str;
            
        }
        
        function dispsubj(subj) {
            str='';
            for(var k=0;k<subj.length;k++)
            {  str+="<option value='"+subj[k][0]+"'>"+subj[k][1]+"</option>";
           }
             return str;
        }
   /*     $('#addQuestionForm').submit(function(e) {
    e.preventDefault();
    $(this).ajaxSubmit({success: function (data)
                       {
                           document.getElementById('content').innerHTML="hello";
                       }});
});
        
        function Add() {

            
            alert("hello");
          $.ajax({
            type: 'post',
            url: 'AddQuestion.php',
            data: $('form').serialize(),
            success: function () {
              $('#content').html("hello");
            }
          });
        }*/
          function add() {
              
              var a=$('form').serialize();
              console.log(a);
              var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {                  
                    alert("Added question  "+ajx.responseText+" successfully");

                }
            };
            ajx.open("POST","  AddQuestion.php",true);
        ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx.send(a);
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
                    document.getElementById("content").innerHTML = "results";
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