<?php 
 include 'connection.php'; 
$sql="UPDATE contests SET Status='active' WHERE ContestId=".$_POST['ConId'];
$result = mysqli_query($con, $sql);
        if($result)
	{        

echo $_POST['ConId']." activated successfully";
        }
        else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}
 ?>