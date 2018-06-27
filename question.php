
<?php
include 'connection.php';

    session_start();

        if(isset($_POST['sql']))
        {  
			$sql2=$_POST['sql'];
			$res="";
			$i=1;
		 
			 $sql2=$con->query($_POST['sql']);
			if($sql2->num_rows >0){
				while($result=$sql2->fetch_assoc()){
				$res[$i++]= $result;	
				}
				
			}
			$json_ar = json_encode($res);
     echo $json_ar;
   }
?>	 
		 