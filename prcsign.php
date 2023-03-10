<?php @session_start(); ?>
<?php  if(empty($_SESSION['user'])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
<?php  include'option/jquery.php';?>
<?php  include'header.php';?>
<meta charset="utf-8"> 
<?PHP
 echo "<br><br><br><br>";
 
 
	if($_POST['method']=='update_sign'){
                   $empno=$_POST['empno']; 
                function removespecialchars($raw) {
    return preg_replace('#[^a-zA-Z0-9.-]#u', '', $raw);
}
        if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "signature/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
            if(!empty($image)){
                $del_photo=mysqli_query($db,"select signature from emppersonal where empno=".$empno);
                $del_photo=mysqli_fetch_assoc($del_photo);
                if(!empty($del_photo['signature'])){
                $location="signature/".$del_photo['signature'];
                include 'function/delet_file.php';
                fulldelete($location);
                }
		$sqlUpdate=mysqli_query($db,"update emppersonal  SET signature='$image' where empno=".$empno); 	
            }else{
               echo "alert('ไม่ได้เลือกลายเซ็นต์ครับ!!!!')";
               echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_Signature.php'>";
            }
	
 							if($sqlUpdate==false){
											 echo "<p>";
											 echo "Update not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='Add_Signature.php' >กลับ</a>";
		
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
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_Signature.php'>";
								}
   
   }
   include_once 'footeri.php'; ?>
 
	
	
 
