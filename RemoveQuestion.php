<?php 
        include 'connection.php'; 
        $sql="DELETE FROM questions WHERE QID=".$_POST['qid'];
        $result = mysqli_query($con, $sql);
            if($result)
            {
    echo "Question:".$_POST['qid']." removed successfully";
            }
            else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
?>