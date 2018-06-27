
<?php
session_start();
$ans=array();
//$_SESSION['ans'];
//$_SESSION['ans'][0]='keerthana';
echo 'hello';
echo  '<input type=radio name="examp" id="op1" onchange="func(this.value)" value="2">
<input type="radio" name="examp" id="op2" value="1">';
//var_dump($_SESSION['ans']);
?>
<!--
<input type=radio name="examp" id="op1" onchange="func()" value="2">
<input type="radio" name="examp" id="op2" value="1">
-->

<script>
function func(x)
    {
		//<?php echo "hello"; ?>
        window.alert("hello"+x+"keerthana");
    }
</script>