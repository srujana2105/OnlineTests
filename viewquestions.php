<html>
    <head>
    </head>
    <body>
<?php 
include 'connection.php';
$sql="SELECT * FROM testdb.questions";
$result=mysqli_query($con,$sql);
$res=mysqli_fetch_all($result,MYSQLI_ASSOC);
        echo " hello";
echo "<table border=2>
        <tr>
            <th>Question ID</th>
            <th>Question</th>
            <th>A</th>
            <th>B</th>
            <th>C</th>
            <th>D</th>
            <th>Answer</th>
        </tr>   
        
";
        $r=sizeof($res);
        for( $i = 0; $i<$r; $i++ ) {
            echo "<tr>
            <td>".$res[$i]["QID"]."</td>
            <td>".$res[$i]["Question"]."</td>
            <td>".$res[$i]["OpA"]."</td>
            <td>".$res[$i]["OpB"]."</td>
            <td>".$res[$i]["OpC"]."</td>
            <td>".$res[$i]["OpD"]."</td>
            <td>".$res[$i]["Answer"]."</td>
            <td><button onclick=edit(".$res[$i]['QID'].")data-toggle='collapse' href='#collapseExample'>Edit</button></td>
          </tr>
          <tr><div class='collapse' id='edit'>djvskdfjhsjvbm </div></tr>
            ";
         }
        echo "</table>";
?>
        <script>
        
        function edit(var q) {
            
        }
        
        </script>
        </body>
</html>