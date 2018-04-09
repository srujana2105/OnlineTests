<?php  
        include 'connection.php'; 
            
//echo '<script>alert("hello")</script>';
    if(isset($_POST['qid']))
    {
        $sql="SELECT SID FROM questions WHERE QID=".$_POST['qid'];
        $result = mysqli_query($con, $sql);
        $value=mysqli_fetch_object($result);
        $sid=$value->SID;
        echo $sid;
        if($sid==(int)$_POST['subject'])
        {
        echo $_POST['qid'];
        $sql="UPDATE questions SET Question='".$_POST['question']."',OpA='".$_POST['opa']."',OpB='".$_POST['opb']."',OpC='".$_POST['opc']."',OpD='".$_POST['opd']."',Answer='".$_POST['answer']."',SID='".$_POST['subject']."' WHERE QID=".$_POST['qid'];
        $result = mysqli_query($con, $sql);
        if($result)
        {
            echo "edited successfully";
            
        }
        else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}}
        else
        {
            $sql="UPDATE subjects SET No = No + 1 WHERE SID=".$_POST['subject'];
        $result = mysqli_query($con, $sql);
            $sql="UPDATE subjects SET No = No - 1 WHERE SID=".$sid;
        $result = mysqli_query($con, $sql);
        }
    }
?>