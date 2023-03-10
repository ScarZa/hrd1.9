<?php @session_start(); ?>
<?php include_once 'connect_ipop.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
<LINK REL="SHORTCUT ICON" HREF="../images/logo.png">
<!-- Bootstrap core CSS -->
<link href="../option/css/bootstrap.css" rel="stylesheet">
<!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
<!-- Add custom CSS here -->
<link href="../option/css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" href="../option/font-awesome/css/font-awesome.min.css">
<!-- Page Specific CSS -->
<link rel="stylesheet" href="../option/css/morris-0.4.3.min.css">
<link rel="stylesheet" href="../option/css/stylelist.css">
</head>

    <body>
<?php
if(!empty($_REQUEST['id'])){
  $empno = $_REQUEST['id'];
  }else{ 
if ($_SESSION['Status']=='USER' or $_SESSION['Status']=='SUSER'  or $_SESSION['Status']=='USUSER') {
  $empno = $_SESSION['user'];
  } }   

  $detial = mysqli_query($db,"SELECT signature from emppersonal where empno='$empno'");
  $Detial = mysqli_fetch_assoc($detial);
  if (!empty($Detial['signature'])) {
    $pic = $Detial['signature'];
    $fol = "../signature/";
} else {
    $pic = 'person.png';
    $fol = "../images/";
}
?>
<div class="row">
    <div class="col-lg-12">
              <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">ลายเซ็นต์</h3>
                    </div>
                  <div class="panel-body"><center><img  src="<?= $fol . $pic; ?>" width="true" height="100" /></center> </div></div></div></div>
<?php                        
include_once '../footeri.php';
?>