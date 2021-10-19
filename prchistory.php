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
    $order = $_POST['order'];
    $posid=$_POST['position'];
    $dep = $_POST['dep'];
    $line = $_POST['line'];
    $pertype = $_POST['pertype'];
    $educat = $_POST['educat'];
    $swday =insert_date($_POST['swday']);
    $method = isset($_POST['method'])?$_POST['method']:'';
    $dictation_id = $_POST['dictation_id'];
    if ($method == 'add_Whistory') {
        function removespecialchars($raw) {
            return preg_replace('#[^ก-ฮะ-็่-๋์a-zA-Z0-9.-]#u', '', $raw);
        }
        if (trim($_FILES["dict_docs"]["name"] != "")) {
            $temporary = explode(".", $_FILES["dict_docs"]["name"]);
            $file_extension = end($temporary);
            $newname = date("d-m-Y His")."DictDoc".$empno.".".$file_extension;
            $dir = "Dictation/";
            $target = $dir.$newname;
            $sourcePath = $_FILES["dict_docs"]['tmp_name']; // Storing source path of the file in a variable
                    move_uploaded_file($sourcePath, $target); // Moving Uploaded file
               
                $dict_docs =$newname;
            }  else {
                $dict_docs ='';
            }
    $add_his= mysqli_query($db,"insert into work_history set empno='$empno', empcode='$order', posid='$posid', depid='$dep', empstuc='$line', emptype='$pertype',
                         education='$educat', dateBegin='$swday',dictation_id='$dictation_id',dict_docs='$dict_docs'");
    mysqli_query($db, "update emppersonal set posid='$posid', depid='$dep', empstuc='$line', emptype='$pertype',
                         education='$educat', dateBegin='$swday' where empno='$empno'");
    if ($add_his==false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_Whistory.php' >กลับ</a>";
        exit();
    }  
}else if ($method == 'update_Whistory') {
    $his=$_REQUEST['his'];
    $dateEnd_w = isset($_POST['dateEnd_w'])?insert_date($_POST['dateEnd_w']):'';
    function removespecialchars($raw) {
        return preg_replace('#[^ก-ฮะ-็่-๋์a-zA-Z0-9.-]#u', '', $raw);
    }
    if (trim($_FILES["dict_docs"]["name"] != "")) {
        $temporary = explode(".", $_FILES["dict_docs"]["name"]);
        $file_extension = end($temporary);
        $newname = date("d-m-Y His")."DictDoc".$empno.".".$file_extension;
        $dir = "Dictation/";
        $target = $dir.$newname;
        $sourcePath = $_FILES["dict_docs"]['tmp_name']; // Storing source path of the file in a variable
                move_uploaded_file($sourcePath, $target); // Moving Uploaded file
           
            $dict_docs =$newname;
            $value = ",dict_docs='$dict_docs'";
        }  else {
            $value ='';
        }
    $edit_his=  mysqli_query($db,"update work_history set empcode='$order', posid='$posid', depid='$dep', empstuc='$line', emptype='$pertype',
                         education='$educat', dateBegin='$swday', dateEnd_w='$dateEnd_w',dictation_id='$dictation_id' $value where his_id='$his' and empno='$empno'");
    $edit_emp=  mysqli_query($db,"update emppersonal set empcode='$order', pid='$order', posid='$posid', depid='$dep', empstuc='$line', emptype='$pertype',
                         education='$educat', dateBegin='$swday' where empno='$empno' ");
    if ($edit_his == false) {
        echo "<p>";
        echo "Update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_Whistory.php' >กลับ</a>";
        exit();
    }  
    
    }

?>