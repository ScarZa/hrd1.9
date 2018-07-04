<?php @session_start(); ?>
<?php include_once 'connection/connect_i.php'; ?>
<?php if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
        <LINK REL="SHORTCUT ICON" HREF="images/logo.png">
        <!-- Bootstrap core CSS -->
        <link href="option/css/bootstrap.css" rel="stylesheet">
        <!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
        <!-- Add custom CSS here -->
        <link href="option/css/sb-admin.css" rel="stylesheet">
        <link rel="stylesheet" href="option/font-awesome/css/font-awesome.min.css">
        <!-- Page Specific CSS -->
        <link rel="stylesheet" href="option/css/morris-0.4.3.min.css">
        <link rel="stylesheet" href="option/css/stylelist.css">
        <script src="option/js/excellentexport.js"></script>
        </head>
    <body>
 
<?php   $method = isset($_POST['method'])?$_POST['method']:$_GET['method'];
	if($method=='add_event'){
                   $event_title=$_POST['massege'];	 	  	 
                   $event_start=$_POST['event_start_date'].' '.$_POST['event_start_time']; 
                   $event_allDay=$_POST['range'];
                   if($event_allDay=='true'){
                   $date_end=date('Y-m-d', strtotime($_POST['event_end_date']."+1 days "));
                   }  else {
                   $date_end=$_POST['event_end_date'];   
                   }
                   $event_end=$date_end.' '.$_POST['event_end_time'];                  
                   
                   $empno=$_SESSION['user'];
                   $process=$_POST['type_event'];
                   
		$insert_event=mysqli_query($db,"insert into tbl_event set event_title='$event_title',event_start='$event_start',event_end='$event_end',event_url='',event_allDay='$event_allDay',
                        empno='$empno',workid='0',process='$process'"); 	
	
                   $event_id=  mysqli_query($db,"select event_id from tbl_event where empno='$empno' and workid='0' order by event_id desc limit 1");
                   $Event_id=  mysqli_fetch_assoc($event_id);
                   $event_url="../add_privatet_calendra.php?id=".$Event_id['event_id']."&method=edit_event";
                   
                   $update_event=mysqli_query($db,"update tbl_event set event_url='$event_url' where event_id='".$Event_id['event_id']."'");
 							if($insert_event==false){
											 echo "<p>";
											 echo "Update not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='add_privatet_calendra.php' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
										echo "<div class='alert alert-success alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>บันทึกข้อมูลเรียบร้อย</center></a> 
								            </div>";								
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=fullcalendar/fullcalendar4.php'>";
								}
   
   }else if($method=='edit_event'){
                   $event_id=$_POST['event_id'];
                   $event_title=$_POST['massege'];	 	  	 
                   $event_start=$_POST['event_start_date'].' '.$_POST['event_start_time']; 
                   $event_allDay=$_POST['range'];
                   
                   if($event_allDay=='true'){
                   $date_end=date('Y-m-d', strtotime($_POST['event_end_date']."+1 days "));
                   }  else {
                   $date_end=$_POST['event_end_date'];   
                   }
                   $event_end=$date_end.' '.$_POST['event_end_time'];                  
                   
                   $process=$_POST['type_event'];
                   
		$insert_event=mysqli_query($db,"update tbl_event set event_title='$event_title',event_start='$event_start',event_end='$event_end',event_allDay='$event_allDay',
                        process='$process' where event_id='$event_id'"); 	
								if($insert_event==false){
											 echo "<p>";
											 echo "Update not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='add_privatet_calendra.php' >กลับ</a>";
		
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
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=fullcalendar/fullcalendar4.php'>";
								}
   
   }elseif ($method=='delete_event') {
                $event_id=$_GET['id'];
                $del_event=  mysqli_query($db,"delete from tbl_event where event_id='$event_id'");
                if($del_event==false){
											 echo "<p>";
											 echo "Update not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='add_privatet_calendra.php' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
										echo "<div class='alert alert-danger alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>ลบข้อมูลเรียบร้อย</center></a> 
								            </div>";								
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=fullcalendar/fullcalendar4.php'>";
								}
}else if($method=='add_holidayevent'){
                   $event_title=$_POST['massege'];	 	  	 
                   $event_start=$_POST['event_start_date']; 
                   $event_allDay = 'true';
                   $event_end=date('Y-m-d', strtotime($event_start."+1 days "));
                   
		$insert_event=mysqli_query($db,"insert into tbl_event set event_title='$event_title',event_start='$event_start',event_end='$event_end',event_url='',event_allDay='$event_allDay',
                        workid='0',process='7'"); 	
 							if($insert_event==false){
											 echo "<p>";
											 echo "Update not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='add_holiday_calendra.php' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
										echo "<div class='alert alert-success alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>บันทึกข้อมูลเรียบร้อย</center></a> 
								            </div>";								
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=add_holiday_calendra.php'>";
								}
   
   }else if($method=='edit_holidayevent'){
                   $event_id=$_POST['event_id'];
                   $event_title=$_POST['massege'];	 	  	 
                   $event_start=$_POST['event_start_date']; 
                   $event_end=date('Y-m-d', strtotime($event_start."+1 days "));
                   
		$update_holidayevent=mysqli_query($db,"update tbl_event set event_title='$event_title',event_start='$event_start',event_end='$event_end'
                        where event_id='$event_id'"); 	
								if($update_holidayevent==false){
											 echo "<p>";
											 echo "Update not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='add_holiday_calendra.php' >กลับ</a>";
		
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
							 		 	echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=add_holiday_calendra.php'>";
								}
   
   }elseif ($method=='delete_holidayevent') {
                $event_id=$_GET['event_id'];
                $del_event=  mysqli_query($db,"delete from tbl_event where event_id='$event_id'");
                if($del_event==false){
											 echo "<p>";
											 echo "Update not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='add_holiday_calendra.php' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
										echo "<div class='alert alert-danger alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>ลบข้อมูลเรียบร้อย</center></a> 
								            </div>";								
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=add_holiday_calendra.php'>";
								}
}
include_once 'footeri.php'; ?>
	
	
 
