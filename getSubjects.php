
<?php
include "connection.php";
    if ($sql = $con->prepare("SELECT * FROM subjects")) {
        $sql->bind_result($sid,$subject,$no);
        $OK = $sql->execute();
    }
    //put all of the resulting names into a PHP array
    $result_array = Array();
    while($sql->fetch()) {
        $result_array[] = array($sid,$subject,$no);
    }
    $json_array = json_encode($result_array);
echo $json_array;
?>