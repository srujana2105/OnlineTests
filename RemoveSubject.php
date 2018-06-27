
<?php 
        include 'connection.php'; 
        $sql="DELETE FROM subjects WHERE SID=".$_POST['sub'];
        $result = mysqli_query($con, $sql);
            if($result)
            {
    echo "Subject:".$_POST['sub']." removed successfully";
            }
            else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
?>