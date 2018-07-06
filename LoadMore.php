
<?php
include "connection.php";
$resultsPerPage=2;
$page_limit=((int)$_POST['page']-1)*($resultsPerPage);
//echo $resultsPerPage,$page_limit,$_POST['sub'],$_POST['page'];
            $sql = "SELECT questions.*,subjects.Subject FROM questions JOIN subjects USING(SID)";
              if(($_POST['sub'])!="undefined")
              {
                  $sql.=" WHERE SID= ".$_POST['sub']." ";
              }
//if(is_numeric($page_limit) && is_numeric($resultsPerPage))
           $sql.=" LIMIT ".$page_limit.", ".$resultsPerPage."";
               // echo $sql;
            $result = mysqli_query($con,$sql);
if (!$result) {
        echo 'MySQL Error: ' . mysqli_error($con);
        exit;
    }
    $result_array = Array();
{
    while($row=mysqli_fetch_assoc($result)) {
        $result_array[] = array($row['QID'],$row['Question'],$row['OpA'],$row['OpB'],$row['OpC'],$row['OpD'],$row['Answer'],$row['Subject']);
    } }
 //   echo $sql;
    //convert the PHP array into JSON format, so it works with javascript
    $json_array = json_encode($result_array);
echo $json_array;
            
                /*console.log((<?php echo $page_limit; $page_limit=$page_limit+$resultsPerPage; ?>));
             Arrobj=<?php echo $json_array;?>;
                    console.log(Arrobj);*/
     
          ?>