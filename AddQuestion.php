<?php 
 include 'connection.php'; 
$sql="INSERT INTO questions VALUES ('NULL','".$_POST['Question']."','".$_POST['OpA']."','".$_POST['OpB']."','".$_POST['OpC']."','".$_POST['OpD']."','".$_POST['Answer']."','".$_POST['Subject']."')";
$result = mysqli_query($con, $sql);
        if($result)
        {
echo $_POST["Question"];
        }
        else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}
$sql="UPDATE subjects SET No = No + 1 WHERE SID=".$_POST['Subject'];
$result = mysqli_query($con, $sql);
 ?>