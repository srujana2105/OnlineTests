<?php  
        include 'connection.php'; 
            
//echo '<script>alert("hello")</script>';
    if(isset($_POST['qid']))
    {
        echo $_POST['qid'];
        $sql="UPDATE testdb.questions SET Question='".$_POST['question']."',OpA='".$_POST['opa']."',OpB='".$_POST['opb']."',OpC='".$_POST['opc']."',OpD='".$_POST['opd']."',Answer='".$_POST['answer']."' WHERE QID=".$_POST['qid'];
        $result = mysqli_query($con, $sql);
        if($result)
        {
            echo "edited successfully";
        }
        else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}
    }
?>