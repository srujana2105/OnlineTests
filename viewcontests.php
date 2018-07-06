<?php
include "connection.php";
$sql = "SELECT contests.*,subjects.Subject FROM contests JOIN subjects USING(SID)";
if(($_POST['sub'])!="undefined")
  {
      $sql.=" WHERE SID= ".$_POST['sub'].";";
  }
//if(is_numeric($page_limit) && is_numeric($resultsPerPage))
               // echo $sql;
            $result = mysqli_query($con,$sql);
if (!$result) {
        echo 'MySQL Error: ' . mysqli_error($con);
        exit;
    }
    $result_array = Array();
{
    while($row=mysqli_fetch_assoc($result)) {
        $result_array[] = array($row['ContestId'],$row['ContestName'],$row['SID'],$row['semester'],$row['duration'],$row['NoofQuestions'],$row['Status']);
    } }
 //   echo $sql;
    //convert the PHP array into JSON format, so it works with javascript
    $json_array = json_encode($result_array);
echo $json_array;
            
                /*console.log((<?php echo $page_limit; $page_limit=$page_limit+$resultsPerPage; ?>));
             Arrobj=<?php echo $json_array;?>;
                    console.log(Arrobj);*/
     
          ?>