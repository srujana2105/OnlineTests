<html>
<head>
    <link rel="stylesheet" type="text/css" href="main.css">
    
    </head>
<body>
<?php
$con = mysqli_connect('localhost', 'root', '');


        if(isset($_POST['sql']))
        {  $sql=$_POST['sql'];$ind=$_POST['ind']+1; 
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);  
          echo '<div class="options">'.$ind.'.'.$row["Question"].'.</div><hr><br><form><div class="options"><input type="radio" name="answer" value="'.$row["OpA"].'">a.'.$row["OpA"].'.</div><br><br><div class="options"><input type="radio" name="answer" value="'.$row["OpB"].'">b.'.$row["OpB"].'.</div><br><br><div class="options"><input type="radio" name="answer" value="'.$row["OpC"].'">c.'.$row["OpC"].'.</div><br><br><div class="options"><input type="radio" name="answer" value="'.$row["OpD"].'">d.'.$row["OpD"].'.</div> </form>
            ';     }     
?>  
    </body>
    </html>