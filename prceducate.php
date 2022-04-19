<?php @session_start(); ?>
<?php if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
} ?>
<body onLoad="KillMe();self.focus();window.opener.location.reload();">
<?php include'option/jquery.php'; ?>
<?php include'header.php'; ?>
<?php
echo	 "<p>&nbsp;</p>	"; 
echo	 "<p>&nbsp;</p>	";
echo "<div class='bs-example'>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>";
echo "<div class='alert alert-dismissable alert-success'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>กำลังดำเนินการ</center></a> 
</div>";

    $empno = $_POST['empno'];
    $teducat = $_POST['teducat'];
    $major = $_POST['major'];
    $inst = $_POST['inst'];
    $grad=insert_date($_POST['end_Graduation']);
    $begin= insert_date($_POST['Graduation']);
    $check_ed=$_POST['check_ed'];
 $method = isset($_POST['method'])?$_POST['method']:'';   
if($method =='add_educate'){
        $add_educate = mysqli_query($db,"insert ignore into educate set empno='$empno', educate='$teducat',
                        major='$major', institute='$inst', enddate='$grad', start_date='$begin', check_ed='$check_ed'");
        if ($add_educate == false) {
            echo "<p>";
            echo "Insert not complete" . mysqli_error($db);
            echo "<br />";
            echo "<br />";

            echo "	<span class='glyphicon glyphicon-remove'></span>";
            echo "<a href='add_educate.php' >กลับ</a>";
        } else {?>
            <!--<center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='detial_educate.php?id=<?=$empno?>'; window.close();">ปิดหน้าต่าง</a></center>-->
        <?PHP 
            }
}elseif($method=='update_educate'){
    $edu=$_POST['edu'];
    $update_educate = mysqli_query($db,"update educate set educate='$teducat',
                        major='$major', institute='$inst', enddate='$grad', start_date='$begin' where empno='$empno' and ed_id='$edu'");
        if ($update_educate == false) {
            echo "<p>";
            echo "Update not complete" . mysqli_error($db);
            echo "<br />";
            echo "<br />";

            echo "	<span class='glyphicon glyphicon-remove'></span>";
            echo "<a href='add_educate.php' >กลับ</a>";
        } else {?>
            <!--<center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='detial_educate.php?id=<?=$empno?>'; window.close();">ปิดหน้าต่าง</a></center>-->
        <?PHP 
            }
}
        ?>
</body>
