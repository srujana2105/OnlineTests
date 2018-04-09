<?php 
 include 'connection.php'; 
$sql="INSERT INTO subjects VALUES ('NULL','".$_POST['subject']."','NULL')";
$result = mysqli_query($con, $sql);
        if($result)
        {
echo $_POST["subject"]." added successfully";
        }
        else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}
 ?>