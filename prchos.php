<?php @session_start(); ?>
<?php  if(empty($_SESSION['user'])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
<?php  include'option/jquery.php';?>
<?php  include'header.php';?>
<meta charset="utf-8"> 
<?PHP
 echo "<br><br><br><br>";
 
 
	if($_POST['method']=='update_hos'){
                   $name=$_POST['name'];
                   $name2=$_POST['name2'];
                   $m_name=$_POST['m_name']; 
                   $url=$_POST['url'];
                function removespecialchars($raw) {
    return preg_replace('#[^a-zA-Z0-9.-]#u', '', $raw);
}
        if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "logo/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
            if(!empty($image)){
                $del_photo=mysqli_query($db,"select logo from hospital");
                $del_photo=mysqli_fetch_assoc($del_photo);
                if(!empty($del_photo['logo'])){
                $location="logo/".$del_photo['logo'];
                include 'function/delet_file.php';
                fulldelete($location);
                }
		$sqlUpdate=mysqli_query($db,"update hospital  SET name='$name',manager='$m_name', url='$url',logo='$image',name2='$name2'"); 	
            }else{
               $sqlUpdate=mysqli_query($db,"update hospital  SET name='$name',manager='$m_name', url='$url',name2='$name2'");  
            }
	
 							if($sqlUpdate==false){
											 echo "<p>";
											 echo "Update not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='Add_Hos.php' >กลับ</a>";
		
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
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php'>";
								}
   
   }
   include_once 'footeri.php'; ?>
 
	
	
 
