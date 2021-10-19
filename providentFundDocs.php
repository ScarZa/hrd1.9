<?php @session_start(); ?>
<?php include_once 'connection/connect_i.php';?>
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
<?php
    include_once ('option/funcDateThai.php');

    $id=$_GET['id'];

    $sql=  "SELECT docs
    FROM providentfund
    WHERE pf_id = ".$id;
    $sql_per = mysqli_query($db,$sql);
    $docs = mysqli_fetch_assoc($sql_per);
    
    if($docs['docs']!='' or $docs['docs']!=null){
      echo "<meta http-equiv='refresh' content='0;url=PFpdf/".$docs['docs']."' />";
    }else{
      echo "ไม่มีเอกสารแนบครับ";
    }
    
    ?>
<body>
</html>