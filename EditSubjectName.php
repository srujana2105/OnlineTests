<?php 
 include 'connection.php'; 
$sql="UPDATE subjects SET Subject='".$_POST['name']."' WHERE SID=".$_POST['sub'];
$result = mysqli_query($con, $sql);
        if($result)
        {
echo $_POST["subject"]." added successfully";
        }
        else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}
 ?>