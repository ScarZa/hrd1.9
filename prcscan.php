<?php
include_once 'head.php';
include'option/jquery.php'; ?>
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
if(isset($_POST['method'])){
$method=$_POST['method'];

if($method=='add_scan'){
    
    $empno=$_POST['empno'];
    $regdate=date("Y-m-d");
    $forget_date=insert_date($_POST['forget_date']);
    $work_scan= isset($_POST['work_scan'])?$_POST['work_scan']:NULL;
    $finish_work_scan= isset($_POST['finish_work_scan'])?$_POST['finish_work_scan']:NULL;
    $register=$_SESSION['user'];
    $see='N';
    $exp_status='W';

$sql=$db->prepare('insert ignore into fingerprint set empno=? , reg_date=? , forget_date=? , work_scan=? , finish_work_scan=? , register=?,
        see=?,exp_status=?');
$sql->bind_param('issssiss',$empno,$regdate,$forget_date, $work_scan,$finish_work_scan,$register,$see,$exp_status);
$sql->execute();
if (empty($sql)) {
    echo "<p>";
        echo "Insert not complete" .mysqli_error ($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_sign.php?id=$empno' >กลับ</a>";
        exit();
}

}elseif($_POST['method']=='edit_scan'){
    $empno=$_POST['empno'];
    $finger_id=$_POST['id'];
    
    $forget_date=insert_date($_POST['forget_date']);
    $work_scan= isset($_POST['work_scan'])?$_POST['work_scan']:NULL;
    $finish_work_scan= isset($_POST['finish_work_scan'])?$_POST['finish_work_scan']:NULL;
    $reason_forget=$_POST['reason_forget'];
    $editer=$_SESSION['user'];
    $editdate=date("Y-m-d");

function removespecialchars($raw) {
    return preg_replace('#[^ก-ฮะ-็่-๋์a-zA-Z0-9.-]#u', '', $raw);
}

if (!empty($_FILES["image"]["name"])) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "explanation/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
if(empty($image)){
$sql=$db->prepare('update fingerprint set forget_date=? , work_scan=? , finish_work_scan=?,reason_forget=?,editer=?,editdate=? 
        where empno=? and finger_id=?');
$sql->bind_param('ssssisii',$forget_date,$work_scan,$finish_work_scan,$reason_forget,$editer,$editdate,$empno,$finger_id);
$sql->execute();    
}else{
                $del_photo=mysqli_query($db,"select explanation from fingerprint where finger_id='$finger_id'");
                $del_photo=mysqli_fetch_assoc($del_photo);
                if(!empty($del_photo['explanation'])){
                $location="explanation/".$del_photo['explanation'];
                include 'function/delet_file.php';
                fulldelete($location);}
    
$sql=$db->prepare('update fingerprint set forget_date=? , work_scan=? , finish_work_scan=?,reason_forget=?,explanation=?,editer=?,editdate=? 
        where empno=? and finger_id=?');
$sql->bind_param('sssssisii',$forget_date,$work_scan,$finish_work_scan,$reason_forget,$image,$editer,$editdate,$empno,$finger_id);
$sql->execute(); 
}
if (empty($sql)) {
    echo "<p>";
        echo "Insert not complete" .mysqli_error ($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_sign.php?id=$empno' >กลับ</a>";
        exit();
}
}elseif($method=='add_late'){
    
    $empno=$_POST['empno'];
    $regdate=date("Y-m-d");
    $take_date_conv=$_POST['late_date'];
    $late_date=insert_date($take_date_conv);
    $late_time=$_POST['take_hour'].':'.$_POST['take_minute'];
    $late=$_POST['late_true'];
    $register=$_SESSION['user'];
    $see='N';
    $exp_status='W';

$sql=$db->prepare('insert ignore into late set empno=? , reg_date=? , late_date=? , late_time=? , register=?,
        see=?,exp_status=?,late=?');
$sql->bind_param('isssisss',$empno,$regdate,$late_date, $late_time,$register,$see,$exp_status,$late);
$sql->execute();
if (empty($sql)) {
    echo "<p>";
        echo "Insert not complete" .mysqli_error ($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_sign.php?id=$empno' >กลับ</a>";
        exit();
}

}elseif($_POST['method']=='edit_late'){
    $empno=$_POST['empno'];
    $late_id=$_POST['id'];
    
    $late_date=insert_date($_POST['late_date']);
    $late_time=$_POST['take_hour'].':'.$_POST['take_minute'];
    $reason_late=$_POST['reason_late'];
    $late=$_POST['late_true'];
    $editer=$_SESSION['user'];
    $editdate=date("Y-m-d");

function removespecialchars($raw) {
    return preg_replace('#[^ก-ฮะ-็่-๋์a-zA-Z0-9.-]#u', '', $raw);
}

if (!empty($_FILES["image"]["name"])) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "explanation/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
if(empty($image)){
$sql=$db->prepare('update late set late_date=? , late_time=?,reason_late=?,late=?,editer=?,editdate=? 
        where empno=? and late_id=?');
$sql->bind_param('ssssisii',$late_date,$late_time,$reason_late,$late,$editer,$editdate,$empno,$late_id);
$sql->execute();    
}else{
                $del_photo=mysqli_query($db,"select explanation from late where late_id='$late_id'");
                $del_photo=mysqli_fetch_assoc($del_photo);
                if(!empty($del_photo['explanation'])){
                $location="explanation/".$del_photo['explanation'];
                include 'function/delet_file.php';
                fulldelete($location);}
    
$sql=$db->prepare('update late set late_date=? , late_time=?,reason_late=?,explanation=?,editer=?,editdate=? 
        where empno=? and late_id=?');
$sql->bind_param('ssssisii',$late_date,$late_time,$reason_late,$image,$editer,$editdate,$empno,$late_id);
$sql->execute();    
}
if (empty($sql)) {
    echo "<p>";
        echo "Insert not complete" .mysqli_error ($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_sign.php?id=$empno' >กลับ</a>";
        exit();
}
}elseif($method=='exp_scan'){
    
    $empno=$_POST['empno'];
    $finger_id=$_POST['id'];
    $reason_forget=$_POST['reason_forget'];
    $explain_date=date("Y-m-d");   
    $exponent=$_SESSION['user'];
    $exp_status='A';

$sql=$db->prepare('update fingerprint set reason_forget=? , explain_date=? , exponent=? , exp_status=?
        where empno=? and finger_id=?');
$sql->bind_param('ssisii',$reason_forget,$explain_date,$exponent,$exp_status,$empno,$finger_id);
$sql->execute();
if (empty($sql)) {
    echo "<p>";
        echo "Insert not complete" .mysqli_error ($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_sign.php?id=$empno' >กลับ</a>";
        exit();
}
}elseif($method=='exp_late'){
    
    $empno=$_POST['empno'];
    $late_id=$_POST['id'];
    $reason_late=$_POST['reason_late'];
    $explain_date=date("Y-m-d");   
    $exponent=$_SESSION['user'];
    $exp_status='A';

$sql=$db->prepare('update late set reason_late=? , explain_date=? , exponent=? , exp_status=?
        where empno=? and late_id=?');
$sql->bind_param('ssisii',$reason_late,$explain_date,$exponent,$exp_status,$empno,$late_id);
$sql->execute();
if (empty($sql)) {
    echo "<p>";
        echo "Insert not complete" .mysqli_error ($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_sign.php?id=$empno' >กลับ</a>";
        exit();
}

}elseif($method=='approve_scan'){
    
    $empno=$_POST['empno'];
    $finger_id=$_POST['id'];
    $exp_status=$_POST['exp_status'];
    $editdate=date("Y-m-d");   
    $editer=$_SESSION['user'];

$sql=$db->prepare('update fingerprint set exp_status=?, editer=? ,  editdate=?  
        where empno=? and finger_id=?');
$sql->bind_param('sisii',$exp_status,$editer,$editdate,$empno,$finger_id);
$sql->execute();
if (empty($sql)) {
    echo "<p>";
        echo "Insert not complete" .mysqli_error ($sql);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_sign.php?id=$empno' >กลับ</a>";
        exit();
}

}elseif($method=='approve_late'){
    
    $empno=$_POST['empno'];
    $late_id=$_POST['id'];
    $exp_status=$_POST['exp_status'];
    $editdate=date("Y-m-d");   
    $editer=$_SESSION['user'];

$sql=$db->prepare('update late set exp_status=?, editer=? ,  editdate=?  
        where empno=? and late_id=?');
$sql->bind_param('sisii',$exp_status,$editer,$editdate,$empno,$late_id);
$sql->execute();
if (empty($sql)) {
    echo "<p>";
        echo "Insert not complete" .mysqli_error ($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_sign.php?id=$empno' >กลับ</a>";
        exit();
}

}
}
include_once 'footeri.php';?>