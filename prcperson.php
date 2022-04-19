<?php @session_start(); ?>
<?php if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
} ?>
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

    $empid = $_POST['empid'];
    $cid = $_POST['cidid'];
    $pname = $_POST['pname'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $sex = $_POST['sex'];
    $bday=insert_date($_POST['bday']);
    $address = $_POST['address'];
    $hname = $_POST['hname'];
    $Province = $_POST['province'];
    $Amphur = $_POST['amphur'];
    $district = $_POST['district'];
    $postcode = $_POST['postcode'];
    $status = $_POST['status'];
    $htell = $_POST['htell'];
    $mtell = $_POST['mtell'];
    $email = $_POST['email'];
    $order = isset($_POST['order'])?$_POST['order']:'';
    $posid= isset($_POST['position'])?$_POST['position']:'';
    $dep = isset($_POST['dep'])?$_POST['dep']:'';
    $line = isset($_POST['line'])?$_POST['line']:'';
    $pertype = isset($_POST['pertype'])?$_POST['pertype']:'';
    $educat = isset($_POST['educat'])?$_POST['educat']:'';
    $swday =isset($_POST['swday'])?insert_date($_POST['swday']):'';
    $teducat = isset($_POST['teducat'])?$_POST['teducat']:'';
    $major = isset($_POST['major'])?$_POST['major']:'';
    $inst = isset($_POST['inst'])?$_POST['inst']:'';
    $grad=isset($_POST['Graduation'])?insert_date($_POST['Graduation']):'';
    $statusw = isset($_POST['statusw'])?$_POST['statusw']:'';
    $reason = isset($_POST['reason'])?$_POST['reason']:'';
    $movedate = isset($_POST['movedate'])?$_POST['movedate']:'';
    $regis_date = isset($_POST['regis_date'])?insert_date($_POST['regis_date']):'';
    $method = isset($_POST['method'])?$_POST['method']:'';
    if ($method == 'add_person') {
        function removespecialchars($raw) {
    return preg_replace('#[^ก-ฮะ-็่-๋์a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "photo/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}

    $add = mysqli_query($db,"insert ignore into emppersonal set pid='$empid', idcard='$cid', pcode='$pname', firstname='$fname',
                lastname='$lname', sex='$sex', birthdate='$bday', address='$address', baan='$hname', provice='$Province',
                   empure='$Amphur', tambol='$district', zipcode='$postcode', emp_status='$status', telephone='$htell',
                      mobile='$mtell', email='$email', empcode='$order', posid='$posid', depid='$dep', empstuc='$line', emptype='$pertype',
                         education='$educat', dateBegin='$swday', status='$statusw', empnote='$reason', dateEnd='$movedate', photo='$image', regis_date='$regis_date'");
    
    $select_empno = mysqli_insert_id($db);
    
    $add_his= mysqli_query($db,"insert ignore into work_history set empno='".$select_empno."', empcode='$order', posid='$posid', depid='$dep', empstuc='$line', emptype='$pertype',
                         education='$educat', dateBegin='$swday'");
    if ($add == false or $add_his==false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_person.php' >กลับ</a>";
    } else {
        $select_ed = mysqli_query($db,"select empno from emppersonal where pid='$empid'");
        $educ = mysqli_fetch_assoc($select_ed);
        $empno = $educ['empno'];

        $add_educate = mysqli_query($db,"insert ignore into educate set empno='$empno', educate='$teducat',
                                                                            major='$major', institute='$inst', enddate='$grad', check_ed='1'");
        if ($add_educate == false) {
            echo "<p>";
            echo "Insert not complete" . mysqli_error($db);
            echo "<br />";
            echo "<br />";

            echo "	<span class='glyphicon glyphicon-remove'></span>";
            echo "<a href='add_person.php' >กลับ</a>";
        } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=add_person.php'>";
        }
    }
}else if ($method == 'edit') {
    $empno=$_REQUEST['edit_id'];
    function removespecialchars($raw) {
    return preg_replace('#[^ก-ฮะ-็่-๋์a-zA-Z0-9.-]#u', '', $raw);}
if (trim($_FILES["image"]["name"] == "")) {
    $edit = mysqli_query($db,"update emppersonal set pid='$empid', idcard='$cid', pcode='$pname', firstname='$fname',
                lastname='$lname', sex='$sex', birthdate='$bday', address='$address', baan='$hname', provice='$Province',
                   empure='$Amphur', tambol='$district', zipcode='$postcode', emp_status='$status', telephone='$htell',
                      mobile='$mtell', email='$email', status='$statusw', empnote='$reason', dateEnd='$movedate', emptype='$pertype', regis_date='$regis_date'
                             where empno='$empno'");
    
}else{
                $del_photo=mysqli_query($db,"select photo from emppersonal where empno='$empno'");
                $del_photo=mysqli_fetch_assoc($del_photo);
                if(!empty($del_photo['photo'])){
                $location="photo/".$del_photo['photo'];
                include 'function/delet_file.php';
                fulldelete($location);}

        if (move_uploaded_file($_FILES["image"]["tmp_name"], "photo/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    
} else{
    $image ='';
}
              
$edit = mysqli_query($db,"update emppersonal set pid='$empid', idcard='$cid', pcode='$pname', firstname='$fname',
                lastname='$lname', sex='$sex', birthdate='$bday', address='$address', baan='$hname', provice='$Province',
                   empure='$Amphur', tambol='$district', zipcode='$postcode', emp_status='$status', telephone='$htell',
                      mobile='$mtell', email='$email', status='$statusw', empnote='$reason', dateEnd='$movedate', photo='$image', emptype='$pertype', regis_date='$regis_date'
                             where empno='$empno'");

}
    if ($edit == false) {
        echo "<p>";
        echo "Update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='pre_person.php' >กลับ</a>";
    
    } else {
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_person.php'>";
        }
    }

?>