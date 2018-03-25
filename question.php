<html>
<head>
    <link rel="stylesheet" type="text/css" href="main.css">
    
    </head>
<body>
<?php
    session_start();
$con = mysqli_connect('localhost', 'root', '');


        if(isset($_POST['sql']))
        {  $sql=$_POST['sql'];$ind=$_POST['ind']+1; 
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);  
          echo '<div class="options">'.$ind.'.'.$row["Question"].'.</div><hr><br>
          <form><div class="options">
          <input type="radio" name="answer" value="'.$row["OpA"].' onchange="func(this.value)">a.'.$row["OpA"].'.</div>
          <br><br>
          <div class="options"><input type="radio" name="answer" value="'.$row["OpB"].'">b.'.$row["OpB"].'.</div>
          <br><br>
          <div class="options"><input type="radio" name="answer" value="'.$row["OpC"].'">c.'.$row["OpC"].'.</div><br><br><div class="options"><input type="radio" name="answer" value="'.$row["OpD"].'">d.'.$row["OpD"].'.
          </div> 
          </form>
            ';
        }
                // echo '<p id="test">hello</p>';
//      echo '<script>
//        function answer(){
//       var ans=document.getElementByName("answer").value;
//        window.alert("hel");
//        </script>
//        ';
//    $_SESSION['answers']['ind']=$row["OpA"];
//    echo "<script>"; 
//    echo "window.alert(".$_SESSION['answers'].");
//           </script>";
    
    ?>  
    <script>
        function func(x){
            $_SESSION['answers'][$ind]=x;
        window.alert("hello");
            var_dump($_SESSION['answers']);
        }
    </script>
    
    </body>
    </html>