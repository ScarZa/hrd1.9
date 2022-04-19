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
    $numdoc=$_POST['numdoc'];
    $app_date=insert_date($_POST['app_date']);
    $year = $_POST['year'];
    $episode=$_POST['episode'];
    $base_salary = $_POST['base_salary'];
    $salary = $_POST['salary'];
    $salary_up = $_POST['salary_up'];
    $percent = $_POST['percent'];
    $eval_id =$_POST['eval_id'];
    $numdoc_edit = $_POST['numdoc_edit'];
    $reason_id = isset($_POST['reason_id'])?$_POST['reason_id']:'';
    $rec_date = date("Y-m-d H:i:s");
    $recorder = $_SESSION['user'];
    $method = isset($_POST['method'])?$_POST['method']:'';
    if ($method == 'add_eval') {
    
    $evaluation= mysqli_query($db,"insert ignore into resulteval set empno='$empno',numdoc='$numdoc',app_date='$app_date', year='$year', episode='$episode', base_salary='$base_salary', salary='$salary', salary_up='$salary_up',
                         percent='$percent', eval_id='$eval_id',numdoc_edit = '$numdoc_edit',reason_id='$reason_id', rec_date='$rec_date', recorder='$recorder'");
    if ($evaluation==false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_eval.php' >กลับ</a>";
        exit();
    }  
}else if ($method == 'update_eval') {
    $reseval_id=$_REQUEST['reseval_id'];
    $edit_eval=  mysqli_query($db,"update resulteval set empno='$empno',numdoc='$numdoc',app_date='$app_date', year='$year', episode='$episode', base_salary='$base_salary', salary='$salary', salary_up='$salary_up',
                         percent='$percent', eval_id='$eval_id',numdoc_edit = '$numdoc_edit',reason_id='$reason_id', rec_date='$rec_date', recorder='$recorder' where reseval_id='$reseval_id' and empno='$empno'");
    if ($edit_eval == false) {
        echo "<p>";
        echo "Update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_eval.php' >กลับ</a>";
        exit();
    }  
    
    }

?>