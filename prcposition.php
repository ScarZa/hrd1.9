<?php @session_start(); ?>
<?php  if(empty($_SESSION['user'])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
<?php  include_once 'option/jquery.php';?>
<?php include_once 'header.php';?>
<meta charset="utf-8"> 
<?PHP
 echo "<br><br><br><br>";
 
      $name= isset($_POST['name'])?$_POST['name']:'';	 	  	 
 	$method = isset($_POST['method'])?$_POST['method']:$_GET['method'];  
	if($method=='update'){
		$dep_id=$_POST['dep_id'];
		$sqlUpdate=mysqli_query($db,"update posid  SET posname='$name' 
		where posId='$dep_id' "); 	
 
	
 							if($sqlUpdate==false){
											 echo "<p>";
											 echo "Update not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='Add_Position.php' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
										echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>แก้ไขข้อมูลเรียบร้อย</center></a> 
								            </div>";								
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_Position.php'>";
								}
   
   }else//-----------------------------------------end delete
   if($method=='delete'){	 	 
   $dep_id=$_GET['dep_id'];	 	  
		$sqlDelete=mysqli_query($db,"delete from posid  
		where posId='$dep_id' "); 
				
 							if($sqlDelete==false){
											 echo "<p>";
											 echo "Delete not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='Add_Position.php' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
										echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>ลบข้อมูลเรียบร้อย</center></a> 
								            </div>";								
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_Position.php'>";
								}
 				 
   }//-----------------------------------------end delete
   elseif($method=='inser_pos'){
 	 	$sqlInsert=mysqli_query($db,"insert ignore into posid  SET  posname='$name' "); 
 
 							if($sqlInsert==false){
											 echo "<p>";
											 echo "Insert not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='Add_Position.php' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
										echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>เพิ่มข้อมูลเรียบร้อย</center></a> 
								            </div>";								
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_Position.php'>";
								}  	
   }
   include_once 'footeri.php';
?>	
 
	
	
 
