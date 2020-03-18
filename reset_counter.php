<?php @session_start(); ?>
<?php
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<?php include 'option/jquery.php'; ?>
<?php include_once 'header.php'; ?>
<?php
echo	 "<p>&nbsp;</p>	"; 
echo	 "<p>&nbsp;</p>	";
echo "<div class='bs-example'>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>";
echo "<div class='alert alert-dismissable alert-success'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>กำลังดำเนินการ</center></a> 
</div>";	


    $reset_counter=mysqli_query($db,"update count set count=0");
    if ($reset_counter == false) {
        echo "<p>";
        echo "update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php.php' >กลับ</a>";
    }else{
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php'>";
    
    }    

?>
</body>