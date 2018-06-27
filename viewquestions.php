<?php 

include 'connection.php';
//$sql="SELECT * FROM testdb.questions";
//$result=mysqli_query($con,$sql);
//$res=mysqli_fetch_all($result,MYSQLI_ASSOC);
    if ($sql = $con->prepare("SELECT * FROM testdb.questions")) {
        $sql->bind_result($qid,$question,$opa,$opb,$opc,$opd,$ans);
        $OK = $sql->execute();
    }
    //put all of the resulting names into a PHP array
    $result_array = Array();
    while($sql->fetch()) {
        $result_array[] = array($qid,$question,$opa,$opb,$opc,$opd,$ans);
    }
    //convert the PHP array into JSON format, so it works with javascript
    $json_array = json_encode($result_array);
        echo $json_array;
?>

     