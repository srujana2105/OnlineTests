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

<ul class="sidenav" id="sidenav">
  	
    <?php  if (isset($_SESSION['username'])) : ?>
    	 <br><p style="margin:10%"><strong><?php echo $_SESSION['username']; ?><br>Faculty ID:</strong><?php echo $_SESSION['fid']; ?>
    <?php endif ?></p><br>
    <li ><a id="Home" class="active" onclick="Home()">Home</a></li>
    <li><a id="VQ" class="inactive" onclick="ViewQuestions()">View questions</a></li>
    <li><a id="AddQuestion" class="inactive" onclick="AddQuestion()">Add question</a></li>
  <li><a id="Results"  class="inactive" onclick="Results()">View Responses and Results</a></li>
    <li><a href="FacultyLogin.php" target="_parent">Logout</a></li>
    </ul>
    <div id="content">
    
    </div>
    <script>
        var arrobj;
        function makeTableHTML(myArray) {
    var result = "<table border=1 id='table_detail' align=center cellpadding=10><tr><th>Question ID</th><th>Question</th><th>Option A</th><th>Option B</th><th>Option C</th><th>Option D</th><th>Answer</th><tr>";
    for(var i=0; i<myArray.length; i++) {
        result += "<tr>";
        for(var j=0; j<myArray[i].length; j++){
            result += "<td>"+myArray[i][j]+"</td>";
        }
        result += "<td><button onclick='show_hide_row("+i+")'>edit</button></td><td><button onclick='removequestion("+i+")'>Remove</button></td></tr><tr id='hidden_row"+i+"'  class='hidden_row'></tr>";
    }
    result += "</table>";

    return result;
}
        function removequestion(j) {
            
            var r=confirm ("Do you want to remove the selected question?")
            if(r)
                {
                   $.ajax({url: "RemoveQuestion.php", type:"post" , data: {qid: arrobj[j][0]}, success: function(result){
        alert(result);
                       ViewQuestions();
    }});
    
                }
        }
        
        function edit(j)
        {
           var x= document.getElementById('editques'+arrobj[j][0]);
            if((x.question.value.trim()=='')||(x.answer.value.trim() == '')||(x.opa.value.trim() == '')||(x.opb.value.trim() == '')||(x.opc.value.trim() == '')||(x.opd.value.trim() == '')) {
            alert("fill all the textfields");
            return;
            }
            // {   alert("enter question");  }
            var r=confirm("Do you want to edit the selected question?");
            if(r)
                {
                    var a=$('#editques'+arrobj[j][0]).serialize();
                    alert(a);
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
        function show_hide_row(i)
        {    
            row='hidden_row'+i;
            console.log(arrobj);
            document.getElementById(row).innerHTML="<td colspan=8><div><form id='editques"+arrobj[i][0]+"'>      <input type='hidden' name='qid' form='editques"+arrobj[i][0]+"' value='"+arrobj[i][0]+"'><label>Question:</label>    <textarea form='editques"+arrobj[i][0]+"' name='question' rows='3' cols='70'>"+arrobj[i][1]+"</textarea>    <br><br>    <label>OpA</label><textarea  form='editques"+arrobj[i][0]+"' name='opa' rows='2' cols='70'>"+arrobj[i][2]+"</textarea><br><br>    <label>OpB</label><textarea  form='editques"+arrobj[i][0]+"' name='opb' rows='2' cols='70'>"+arrobj[i][3]+"</textarea><br><br>    <label>OpC</label> <textarea  form='editques"+arrobj[i][0]+"' name='opc' rows='2' cols='70'>"+arrobj[i][4]+"</textarea><br><br><label>OpD</label><textarea  form='editques"+arrobj[i][0]+"' name='opd' rows='2' cols='70'>"+arrobj[i][5]+"</textarea><br><br><label>Answer</label><textarea  form='editques"+arrobj[i][0]+"' name='answer' rows='2' cols='70'>"+arrobj[i][6]+"</textarea><br><br> <input form='editques"+arrobj[i][0]+"' type='button' onclick='edit("+i+")' value='Edit'></form></div><td>";
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
        
        function AddQuestion() {
            
           document.getElementsByClassName("active")[0].className="inactive";
            var e=document.getElementById("AddQuestion");
            e.className="active"; document.getElementById("content").innerHTML="<form id='addQuestionForm'><br><label>Question:</label><textarea name='Question'></textarea><br><label>Option A:</label><textarea name='OpA'></textarea><br><label>Option B:</label><textarea name='OpB'></textarea><br><label>Option C:</label><textarea name='OpC'></textarea><br><label>Option D:</label><textarea name='OpD'></textarea><br><label>Answer:</label><textarea name='Answer'></textarea><br><input type='button' onclick='add()' value='Add'></form>";
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
        
        document.getElementsByClassName("active")[0].className="inactive";
            var e=document.getElementById("Results");
            e.className="active";
        
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
                    document.getElementById("content").innerHTML = "results";
                }
            };
            ajx.open("POST","Results.php",true);
        ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx.send();
        
          }
        function Home()  {
        document.getElementsByClassName("active")[0].className="inactive";
            var e=document.getElementById("Home");
            e.className="active";
            
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