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
    <li><a href="faculty.php?logout=1">Logout</a></li>

    </ul>
    <div id="content">
    
          
    </div>
    <script>
		onload=Home();
        var added_ques=[];
        var added_ques_id=[];
        var VQstr;
        var arrobj=[];
        var arrobj_adcon=[];
        var Arrobj;
        var subj;
        var str='';
        var str1='';
        var VQstr;
        var r=0;
        var r_adcon=0;
        var sub;
        var subject;
        var rpp=2;
        var name_contest="",dur_contest="",sem_contest="",sub_contest="";

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

            ViewQuestions();

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
            str1="<div style='position:fixed;margin-rigth:5%;margin-left:50%;margin-top:25px;background-color:white;height:50px;overflow:auto;'><input id='addsub' type='text' size=30><button onclick='addSubject()'>Add subject</button></div><br><br><br><table border=1 id='table_detail' style='margin-rigth:50%;margin-top:-25px;margin-left:0' align=center cellpadding=10><tr><th>Subject ID</th><th>Subject</th><th>No. of questions</th>";
            for(var i=0;i<subj.length;i++)
                {
                    str1+="<tr><td>"+subj[i][0]+"</td><td>"+subj[i][1]+"</td><td>"+subj[i][2]+"</td><td><button onclick='show_hide("+i+")'>edit</button></td><td><button onclick='removeSubject("+i+")'>remove</button></td></tr><tr id='hidden_row"+(i)+"' class='hidden_row'></tr>";
                    //$("#hidden_row"+i).toggle();
                }
            str+="</table>";
            console.log(str1);
            $('#content').html(str1);
            
        }
        function show_hide(j)
        {    $("#hidden_row"+j).toggle();
            document.getElementById("hidden_row"+j).innerHTML="<td colspan=3><table><tr><div align='center'><label>enter new subject name:</label></div></tr><tr><div align='center'><input type='text' size=30 id='newsubname"+j+"'><button onclick='editsubj("+j+")'>Change</button></div></tr></td>";
        }
        
        function editsubj(j)
        {
            alert(subj[j][0]);
            var newname=document.getElementById("newsubname"+j);
            alert(newname.value);
            var c=confirm(newname.value+"Do you want to edit the selected subject name?");
            if(c)
                {
                    $.ajax({url: "EditSubjectName.php", type:"post" , data: {sub: subj[j][0],name:newname.value},success: function(result){
        alert(result);
        ViewSubjects();}, async: false                });
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
        
        function ViewQuestions()  {
            $('#content').html(''); document.getElementsByClassName("active")[0].className="inactive";
            var e=document.getElementById("VQ");
            e.className="active";
            arrobj=[];
            VQstr="<div id='filter' style='position:fixed;background-color:white;height:50px;width:80%;overflow:auto;margin-top:20px;'><div style='float:left;'><label>Subject</label><select name='subject'><option value='undefined'>All</option>"+dispsubj(subj)+"</select><button onclick='applyfilter()'>Apply</button></div></div><br><br>";
            str1='';
            r=0;
            page=1;
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
            var nstr;
            if(page==1)
            {
                if(parsedarray.length==0)
                {document.getElementById("content").innerHTML=VQstr+"No Questions in this category"; return;}
                else{
                    VQstr+= "<table border=1 id='table_detail' style='margin-top:40px;float:left' align=center cellpadding=10><tr><th>Question ID</th><th>Question</th><th>Option A</th><th>Option B</th><th>Option C</th><th>Option D</th><th>Answer</th><th>Subject</th></tr>";
                }
            }
            
                    str1+= makeTableHTML(parsedarray);
                nstr=str1+"</table>";
           // console.log(nstr);
               //alert(document.getElementById("content").innerHTML); 
                
                if(parsedarray.length == rpp){
            nstr=nstr+"<br/><button style='margin-top:15px' onclick='loadmore()'>Load More</button>";
                }document.getElementById("content").innerHTML=VQstr+nstr;
                   // alert(nstr);
               page++; //document.getElementById("content").innerHTML+= "</table>";
                
            
        }
        function AddQuestion() {
            
           var x; document.getElementsByClassName("active")[0].className="inactive";
            var e=document.getElementById("AddQuestion");
            e.className="active"; 
            str="<form id='addQuestionForm'><br><label>Question:</label><textarea rows='4' cols='100' name='Question'></textarea><br><label>Option A:</label><textarea rows='4' cols='100' name='OpA'></textarea><br><label>Option B:</label><textarea rows='4' cols='100' name='OpB'></textarea><br><label>Option C:</label><textarea rows='4' cols='100' name='OpC'></textarea><br><label>Option D:</label><textarea rows='4' cols='100' name='OpD'></textarea><br><label>Answer:</label><textarea rows='4' cols='100' name='Answer'></textarea><br><label>Subject:</label><select name='Subject'>"+dispsubj(subj)+"</select><br><br><input type='button' onclick='add()' value='Add'></form>"; document.getElementById("content").innerHTML=str;
            
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
    }
		//document.getElementById("back").onclick=response();
              
		
        function Home()  {
            getSubjects();
            subject="undefined";
        document.getElementsByClassName("active")[0].className="inactive";
            var e=document.getElementById("Home");
            e.className="active";
			document.getElementById("content").innerHTML="<div id='content-header' style='position:fixed;background-color:white;height:50px;width:80%;margin-top:25px;overflow:auto;'><div style='float:left;'><label>Subject</label><select name='subject'><option value='undefined'>All</option>"+dispsubj(subj)+"</select><button onclick='applyfilter_viewcon()'>Apply</button></div><div style='float:right;margin-right:220px'><button id='addcontest'>Add a contest</button></div><div  style:'float:right;'><input type='button' value='Remove a contest' id='remvcontest' onclick='removecontest()'></div></div><br><br><br/><div id='contentpane' style='margin-top:-50px;'></div>";
            ViewContests();
            
            document.getElementById('addcontest').onclick=function() {
            alert();
             contest_store=document.getElementById("content").innerHTML;
				var acon="<button style='margin-top:50px' onclick='Home()'>Back</button><br/><div style='margin-rigth:30%;margin-top:80px;margin-left:20%'><form><table cellpadding=5><tr><td><label>Name of contest:</label></td><td><input type='text' style='width:250;' id='name'></td></tr><tr><td><label>Duration (in minutes):</label></td><td><input type='number' placeholder='90' style='width:50;' id='duration'></td></tr><tr><td><label>Semester</label></td><td><select id='semester'><option value='1'>I</option><option value='2'>II</option><option value='3'>III</option><option value='4'>IV</option><option value='5'>V</option><option value='6'>VI</option><option value='7'>VII</option><option value='8'>VIII</option></select></td></tr><tr><td><label>Subject:</label></td><td><select id='subject'>"+dispsubj(subj)+"</select></td></tr></table></div><br/><input type='button' id='create' value='Next' onclick='Create()'></form>";
                document.getElementById("content").innerHTML=acon;
            }
            
            document.getElementById("remvcontest").onclick=function(){
					rcon="<button onclick='Home()'>Back</button><div style='margin-top:50px'><input type='text' placeholder='contest to be removed' id='rname'></div><br/><div style='margin-top:20px'><input type='button' value='Remove contest' onclick='Remove()'></div>";
					
					document.getElementById("content").innerHTML=rcon;
				}
              }
        
            function applyfilter_viewcon()
            {
                subject=document.getElementById('content-header').getElementsByTagName("select")[0].value;
                alert(subject);
                ViewContests();
            }
            
        
        
        function makeTableHTML_adcon(myArray) {
    var result='';r_adcon
            console.log(myArray);
    for(var k=0; k<myArray.length; k++,r_adcon++) {
        result += "<tr>";
        for(var j=0; j<myArray[k].length; j++){
            result += "<td>"+myArray[k][j]+"</td>";
        }
       // result+="<td"+subj[i][]
       // console.log(r);
        arrobj_adcon.push(myArray[k]);
        result += "<td><button onclick='add_question("+(r_adcon)+")'>Add to contest</button></td></tr>";
    }
    return result;
}
        function add_question(i)
        {
            if(added_ques_id.includes(arrobj_adcon[i][0]))
            { alert("that question was already selected"); }
            else{
            added_ques.push(arrobj_adcon[i]);
            added_ques_id.push(arrobj_adcon[i][0]);
            document.getElementById("view_con_ques").innerHTML="View added Questions("+added_ques_id.length+")";
                alert(document.getElementById("view_con_ques").innerHTML);
            }
        }
        function aq()
        {
            added_ques_id=[];
            added_ques=[];
             add_ques_to_con();
        }
        function back()
        {
            document.getElementById("content").innerHTML=store;
        }
        var store;
        function vcq()
        {
            r=0;
            if(added_ques.length==0)
             {   result='<div  style="position:fixed;margin-right:70%;margin-top:30px"><button onclick="back()">Back</button></div>'; }
            else{
            result=`<div style="position:fixed;margin-right:70%;margin-top:30px"><button onclick="back()">Back</button></div><table border=1 id='table_detail' style='margin-top:100px;float:left' align=center cellpadding=10><tr><th>Question ID</th><th>Question</th><th>Option A</th><th>Option B</th><th>Option C</th><th>Option D</th><th>Answer</th><th>Subject</th></tr>`;
            for(var k=0; k<added_ques.length; k++,r++) {
        result += "<tr>";
        for(var j=0; j<added_ques[k].length; j++){
            result += "<td>"+added_ques[k][j]+"</td>";
        }
                result=result+"<td><button onclick='rem_question("+(r)+")'>Remove</button></td></tr>";
        }
            result+="</table></br><div style='float:right;width:75%;height:30px;position:fixed;background-color:white;margin-top:45%'><button style='float:right;margin-right:20px;' onclick='create()'>Create contest</button></div>";  
            }
         document.getElementById("content").innerHTML=result;
        }
        
            function view_con_ques()
        {   store=document.getElementById("content").innerHTML;
            vcq();
        }
        
        function rem_question(i)
        {
            added_ques_id.splice(i,1);
            added_ques.splice(i,1);
            vcq();
        }
        
        function add_ques_to_con()
            {
            arrobj_adcon=[];
                VQstr="<div style='position:fixed;background-color:white;margin-top:10px;height:150px;width:70%;overflow:auto;'><h1>Select questions to be added</h1><br/><div id='filter' style='float:left'><label>Subject</label><select name='subject'><option value='undefined'>All</option>"+dispsubj(subj)+"</select><button onclick='applyfilter_adcon()'>Apply</button></div><div style='float:right'><button id='view_con_ques' onclick='view_con_ques()'>View contest questions("+added_ques.length+")</button></div><br><br></div>";
            str1='';
            r_adcon=0;
            page=1;
           // alert(VQstr);
            loadmore_adcon(); 
        }
        
        function applyfilter_adcon()
        {
         sub=document.getElementById('filter').getElementsByTagName("select")[0].value;
            add_ques_to_con();
           /* VQstr="<h1>Select questions to be added</h1><div id='filter' style='position:fixed;'><label>Subject</label><select name='subject'><option value='undefined'>All</option>"+dispsubj(subj)+"</select><button onclick='applyfilter_adcon()'>Apply</button></div><div style='float:right'><button id='view_con_ques' onclick='view_con_ques()'>View contest questions("+added_ques.length+")</button></div><br><br>";
            str1='';
            r=0;
            page=1;
           // alert(VQstr);
            loadmore_adcon(); */
            }
        
        
        function loadmore_adcon() {
            
                var ajx = new XMLHttpRequest();
                ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
                    Arrobj=(ajx.responseText);
                    load_adcon(Arrobj);
            };
                }
                ajx.open("POST","LoadMore.php",true);
        ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            cred="page="+page;
                cred+="&sub="+sub;
            ajx.send(cred);
            
        
            }
        function load_adcon(Arrobj) {
           // alert(Arrobj);
           // alert(makeTableHTML(JSON.parse(Arrobj)));
            
            var parsedarray=JSON.parse(Arrobj);
            var nstr;
            if(page==1)
            {
                if(parsedarray.length==0)
                {document.getElementById("content").innerHTML=VQstr+"No Questions in this category"; return;}
                else{
                    VQstr+= "<table border=1 id='table_detail' style='margin-top:180px;float:left;width:90%' align=center cellpadding=10><tr><th>Question ID</th><th>Question</th><th>Option A</th><th>Option B</th><th>Option C</th><th>Option D</th><th>Answer</th><th>Subject</th></tr>";
                }
            }
            
                    str1+= makeTableHTML_adcon(parsedarray);
                nstr=str1+"</table>";
           // console.log(nstr);
               //alert(document.getElementById("content").innerHTML); 
                
                if(parsedarray.length == rpp){
            nstr=nstr+"<br /><button style='margin-top:10px' onclick='loadmore_adcon()'>Load More</button>";
                }document.getElementById("content").innerHTML=VQstr+nstr;
                   // alert(nstr);
               page++; //document.getElementById("content").innerHTML+= "</table>";
                
            
        }
			
			
		function ViewContests(){
			window.alert("hello srujana");
			 $.ajax({url: "viewcontests.php", type:"post" ,data:{sub:subject}, success: function(result)
                     {
                         DispCon(JSON.parse(result));
                        console.log(result);
                     }
                     , async: true
    });
		}
        
        function DispCon(CA)
        {
            alert(CA);
            var contest_result='';
            var ActiveCon=[];
            var DefaultCon=[];
            var CompletedCon=[];
            var str3='<table border=1 id="table_detail" align=center style="width:80%;float:left;margin-right:50%;" cellpadding=10><tr><th>Contest ID</th><th>Contest Name</th><th>Subject</th><th>Duration</th><th>Semester</th><th>Status</th></tr>';
            var max=7;
            for(var i=0;i<CA.length;i++)
                {
                    if(CA[i][max-1]=='active')
                        {
                            ActiveCon.push(CA[i]);
                        }
                    if(CA[i][max-1]=='default')
                        {
                            DefaultCon.push(CA[i]);
                        }
                    if(CA[i][max-1]=='completed')
                        {
                            CompletedCon.push(CA[i]);
                        }
                }
            if(ActiveCon.length>0)
            {   contest_result+=("<br /><h3 style='float:left'>Active Contests</h3>"+str3);
            for(var k=0; k<ActiveCon.length; k++) {
        contest_result += "<tr>";
        for(var j=0; j<ActiveCon[k].length; j++){
            contest_result += "<td>"+ActiveCon[k][j]+"</td>";
        }
        contest_result += "<td><button onclick='deactivate("+(ActiveCon[k][0])+")'>Deactivate</button></td></tr>"; }
             contest_result+="</table>";}
            
            
             if(CompletedCon.length>0)
            { contest_result+=("<br /><h3 style='float:left'>Completed Contests</h3>"+str3);
            for(var k=0; k<CompletedCon.length; k++) {
        contest_result += "<tr>";
        for(var j=0; j<CompletedCon[k].length; j++){
            contest_result += "<td>"+CompletedCon[k][j]+"</td>";
        }
        contest_result += "<td><button onclick='ViewResults("+(CompletedCon[k][0])+")'>View Results</button></td></tr>"; }
             contest_result+="</table>";}
            
            if(DefaultCon.length>0)
            { contest_result+=("<br /><h3 style='float:left'>Contests</h3>"+str3);
            for(var k=0; k<DefaultCon.length; k++) {
        contest_result += "<tr>";
        for(var j=0; j<DefaultCon[k].length; j++){
            contest_result += "<td>"+DefaultCon[k][j]+"</td>";
        }
        contest_result += "<td><button onclick='activate("+(DefaultCon[k][0])+")'>Activate</button></td></tr>"; }
             contest_result+="</table>";}
            
            document.getElementById("contentpane").innerHTML=contest_result;
            alert(contest_result);
        }

        function activate(conid)
        {
            $.ajax({url: "ActivateContest.php", type:"post" , data:{ConId:conid} , success: function(result){alert(result); }, async: true
    });
            ViewContests();
            
        }
        
        function deactivate(conid)
        {
             $.ajax({url: "DeactivateContest.php", type:"post" , data:{ConId:conid} , success: function(result){alert(result); }, async: true
    });
            ViewContests();
            
        }
        
        function Create()
        {
             name_contest=document.getElementById("name").value;
            dur_contest=document.getElementById("duration").value;
            sem_contest=document.getElementById("semester").value;
             sub_contest=document.getElementById("subject").value;
            add_ques_to_con();
        }
		function create(){
			window.alert('hello');
					var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
                    document.getElementById("sidenav").innerHTML =ajx.responseText;
                    add_ques_to_con();
                }
            };
				creds="&name="+name_contest+"&dur="+dur_contest+"&sem="+sem_contest+"&sub="+sub_contest+"&ques="+JSON.stringify(added_ques_id);
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