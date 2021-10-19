<?php @session_start(); ?>
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
<?php if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
} ?>
<script language="JavaScript" type="text/javascript"> 
var StayAlive = 1; // เวลาเป็นวินาทีที่ต้องการให้ WIndows เปิดออก 
function KillMe()
{ 
setTimeout("self.close()",StayAlive * 1000); 
} 
</script>
</head>

    <body onLoad="KillMe();self.focus();window.opener.location.reload();">
<?php include'option/jquery.php'; ?>
<?php
echo	 "<p>&nbsp;</p>	"; 
echo	 "<p>&nbsp;</p>	";
echo "<div class='col-lg-12'>
    <div class='bs-example '>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>";
echo "<div class='alert alert-dismissable alert-success col-lg-12'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>กำลังดำเนินการ</center></a> 
</div></div>";
include 'connection/connect_i.php';

                    function insert_date($take_date_conv)
                    {
                        $take_date=explode("-",$take_date_conv);
			 $take_date_year=@$take_date[2]-543;
			 $take_date=$take_date_year."-".@$take_date[1]."-".@$take_date[0];
                         return $take_date;
                    }
    $empno=$_POST['empno'];
    $regdate=insert_date($_POST['regdate']);
    $enddate= isset($_POST['enddate'])?insert_date($_POST['enddate']):'';
    $deductdate=insert_date($_POST['deductdate']);
    $recdate = date("Y-m-d H:i:s");
    $recorder = $_SESSION['user'];
    $method = isset($_POST['method'])?$_POST['method']:'';
    if ($method == 'add_deduct') {
      function removespecialchars($raw) {
        return preg_replace('#[^ก-ฮะ-็่-๋์a-zA-Z0-9.-]#u', '', $raw);
    }
    if (trim($_FILES["docs"]["name"] != "")) {
        $temporary = explode(".", $_FILES["docs"]["name"]);
        $file_extension = end($temporary);
        $newname = date("d-m-Y His")."Doc".$empno.".".$file_extension;
        $dir = "PFpdf/";
        $target = $dir.$newname;
        $sourcePath = $_FILES["docs"]['tmp_name']; // Storing source path of the file in a variable
                move_uploaded_file($sourcePath, $target); // Moving Uploaded file
           
            $docs =$newname;
        }  else {
            $docs ='';
        }
    $pf= mysqli_query($db,"insert into providentfund set empno='$empno',regdate='$regdate',enddate='$enddate', deductdate='$deductdate', docs='$docs', recdate='$recdate', recorder='$recorder'");
    if ($pf==false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_deduct.php' >กลับ</a>";
        exit();
    }  
}else if ($method == 'update_deduct') {
    $pf_id=$_REQUEST['pf_id'];
    $edit_eval=  mysqli_query($db,"update providentfund set regdate='$regdate',enddate='$enddate', deductdate='$deductdate', recdate='$recdate', recorder='$recorder' where pf_id='$pf_id' and empno='$empno'");
    if ($edit_eval == false) {
        echo "<p>";
        echo "Update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_deduct.php' >กลับ</a>";
        exit();
    }  
    
    }

?>