<?PHP include_once 'header.php';include 'function/string_to_ascii.php';?>
<?PHP
 echo "<br><br><br><br>";
 
      $user_name= isset($_POST['name'])?$_POST['name']:'';	 	  	 
      $admin= isset($_POST['admin'])?$_POST['admin']:'';	
      //เข้ารหัส ascii//$user_account=md5(string_to_ascii(trim($_POST['user_account'])));
      $user_account= isset($_POST['user_account'])?md5(trim($_POST['user_account'])):'';
      $username= isset($_POST['user_account'])?$_POST['user_account']:'';
      //เข้ารหัส ascii//$user_pwd= md5(string_to_ascii(trim($_POST['user_pwd'])));
      $user_pwd= isset($_POST['user_pwd'])?md5(trim($_POST['user_pwd'])):'';

 	$method = isset($_POST['method'])?$_POST['method']:$_GET['method'];  
	if($method=='update'){
        $ID=$_POST['ID'];    
	$user_idPOST=$_POST['user_id'];
        $mobile=$_POST['mobile'];
 
		if(!empty($_POST['user_pwd'])){
 		$sqlUpdate=mysqli_query($db,"update member set Name='$user_name' ,  
 		Status='$admin', Username='$user_account' , Password='$user_pwd',user_name='$username'  
		where Name='$user_idPOST' and UserID='$ID' "); 
		}else{ 
		$sqlUpdate=mysqli_query($db,"update member set Name='$user_name' ,user_name='$username',  
 		Status='$admin', Username='$user_account'   
		where Name='$user_idPOST' and UserID='$ID' "); 	
		}
	
 							if($sqlUpdate==false){
											 echo "<p>";
											 echo "Update not complete ".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='Add_User.php' >กลับ</a>";
		
								}else{
                                                                    $mobile_update=  mysqli_query($db,"update emppersonal set mobile='$mobile'
                                                                            where empno='$user_idPOST'");
                                                                    if($sqlUpdate==false){
                                                                         echo "<p>";
											 echo "Update not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='Add_User.php' >กลับ</a>";
                                                                    }
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
									echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>แก้ไขข้อมูลผู้ใช้งานเรียบร้อย</center></a> 
								            </div>";					
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_User.php'>";
								}
   
   }//-----------------------------------------end update
   else if($method=='delete'){
       $ID=$_REQUEST['ID'];
       $user_idGet=$_REQUEST['user_id'];	 	  
		$sqlDelete=mysqli_query($db,"delete from member  
		where Name='$user_idGet' and UserID='$ID' "); 
				
 							if($sqlDelete==false){
											 echo "<p>";
											 echo "Delete not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='Add_User.php' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
									echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>ลบผู้ใช้งานเรียบร้อย</center></a> 
								            </div>";								
							 		 	echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_User.php'>";
								}
 				 
   }//-----------------------------------------end delete
   else{
 	 	$sqlInsert=mysqli_query($db,"insert into member  SET    Name='$user_name' ,  
 		Status='$admin', Username='$user_account' , Password='$user_pwd',user_name='$username'  "); 

	
 							if($sqlInsert==false){
											 echo "<p>";
											 echo "Insert not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='Add_User.php' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
										echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>เพิ่มผู้ใช้งานเรียบร้อย</center></a> 
								            </div>";								
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_User.php'>";
								}  	
   }
   $db->close();
?>		

 
	
	
 