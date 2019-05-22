<?php @session_start(); ?>
<?php
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<?php include 'option/jquery.php'; ?>
<?php include_once 'header.php'; ?>
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

$adminId=$_SESSION['user'];
$empno=$_REQUEST['empno'];
$depno= isset($_REQUEST['depno'])?$_REQUEST['depno']:'';
$emptype= isset($_REQUEST['emptype'])?$_REQUEST['emptype']:'';

$method = isset($_POST['method'])?$_POST['method']:$_GET['method'];
if($method=='leave'){
    if($_SESSION['Status']=='ADMIN'){
$date_reg=insert_date($_POST['date_reg']);
    }else{
$date_reg=date('Y-m-d');        
    }
$typel = $_POST['typel'];
$date_s=insert_date($_POST['date_s']);
$date_e=insert_date($_POST['date_e']);
$amount = $_POST['amount'];
$reason_l = $_POST['reason_l'];
$add_conn = $_POST['add_conn'];
$tell = $_POST['tell'];
$cert = $_POST['cert'];
$note = $_POST['note'];
$statusla='Y';
$regis='W';

include 'option/function_date.php';
if($date >= $bdate and $date <= $edate){
    if($date > $date_s and $date > $date_e){
        $beg_date="$y-10-01";
        $en_date="$Yy-09-30";
    //$year = date('Y')+1; 
    } else {
        $beg_date="$Y-10-01";
        $en_date="$y-09-30";
    //$year = date('Y')+1;        
    }
}else{
    $beg_date="$Y-10-01";
    $en_date="$y-09-30";
    //$year = date('Y');
}
$year = ($_POST['fiscal_year']-543);

$check_leave_date=  mysqli_query($db,"select begindate from work where enpid='$empno' and begindate='$date_s' and statusla='Y'");
$num_row = mysqli_num_rows($check_leave_date);
if (empty($num_row)) {
$sql_leave=  mysqli_query($db,"select workid from work where enpid='$empno' and  typela='$typel' and statusla='Y' and begindate between '$beg_date' and '$en_date' ORDER BY workid desc");
$befor_leave=  mysqli_fetch_assoc($sql_leave);

$befor_workid=$befor_leave['workid'];
for($i = 0; $i < count(isset($_POST["typela"])?$_POST["typela"]:''); $i++){
    if (!empty($_POST["typela"][$i])) {
        $typela[$i]= $_POST["typela"][$i];
        $last_amount[$i]= $_POST["leave_type"][$i];
    }
    
}

$insert_print=  mysqli_query($db,"insert into print_leave set empno='$empno', befor_workid='$befor_workid',last_type1='".@$typela[0]."',last_amount1='".@$last_amount[0]."',
        last_type2='".@$typela[1]."',last_amount2='".@$last_amount[1]."',last_type3='".@$typela[2]."',last_amount3='".@$last_amount[2]."',last_type4='".@$typela[3]."',last_amount4='".@$last_amount[3]."',
        last_type5='".@$typela[4]."',last_amount5='".@$last_amount[4]."',last_type6='".@$typela[5]."',last_amount6='".@$last_amount[5]."',last_type7='".@$typela[6]."',last_amount7='".@$last_amount[6]."'");
if ($insert_print == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='main_leave.php' >กลับ</a>";
    }else{

function removespecialchars($raw) {
    return preg_replace('#[^a-zA-Z0-9.-]#u', '', $raw);
}

if (!empty($_FILES["image"]["name"])) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "myfile/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
$regis_leave=  mysqli_query($db,"select count from count where count_name='regis_leave'");
$Regis_Leave=  mysqli_fetch_assoc($regis_leave);
$Ln=$Regis_Leave['count']+1;
$Y=date('y')+43;
$leave_no="$Y/$Ln";
    $update_count=  mysqli_query($db,"update count set count='$Ln' where count_name='regis_leave'");
    $insert_leave=  mysqli_query($db,"insert into work set enpid='$empno', reg_date='$date_reg', leave_no='$leave_no', begindate='$date_s', enddate='$date_e',
                                typela='$typel', amount='$amount', abnote='$reason_l', address='$add_conn', tel='$tell',
                                    check_comment='$cert', comment='$note', pics='$image', idAdmin='$adminId', statusla='$statusla',depId='$depno',regis_leave='$regis' ");
    $event=  mysqli_query($db,"select CONCAT(firstname,' ',lastname) as fullname from emppersonal where empno='$empno'");
    $Event=mysqli_fetch_assoc($event);
    $workid=mysqli_query($db,"select workid from work where enpid='$empno' ORDER BY workid DESC");
    $Workid=mysqli_fetch_assoc($workid);
    
    $date_end=date('Y-m-d', strtotime("$date_e+1 days "));
    $insert_event=mysqli_query($db,"insert into tbl_event set event_title='".$Event['fullname']."',event_start='$date_s',event_end='$date_end',event_allDay='true',
            empno='$empno',workid='$Workid[workid]',typela='$typel',process='0'");
        echo $year;
        $L_day=  mysqli_query($db,"select * from leave_day where empno='$empno' and fiscal_year='$year'");
        $L_Day=  mysqli_fetch_assoc($L_day);
    if($typel=='1'){
        $leave=$L_Day['L1']-$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L1='$leave' where empno='$empno' and fiscal_year='$year'");
      }  elseif($typel=='2'){
        $leave=$L_Day['L2']-$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L2='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='3'){
        $leave=$L_Day['L3']-$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L3='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='4'){
        $leave=$L_Day['L4']-$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L4='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='5'){
        $leave=$L_Day['L5']-$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L5='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='6'){
        $leave=$L_Day['L6']-$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L6='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='7'){
        $leave=$L_Day['L7']-$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L7='$leave' where empno='$empno' and fiscal_year='$year'");
      } 
          
          if ($insert_leave == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='main_leave.php' >กลับ</a>";
    }else{
    $selec_work= mysqli_query($db,"select workid from work  where enpid='$empno' and reg_date='$date_reg' and typela='$typel' ORDER BY workid desc");
    $workId=  mysqli_fetch_assoc($selec_work);
    $select_print_id=  mysqli_query($db,"select print_id from print_leave  where empno='$empno' order by print_id desc");
    $Print_id=  mysqli_fetch_assoc($select_print_id);
    $update_work=mysqli_query($db,"update print_leave set workid='$workId[workid]' where print_id='".$Print_id['print_id']."' and befor_workid='$befor_workid' and empno='$empno'");
    if ($update_work == false) {
        echo "<p>";
        echo "update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='main_leave.php' >กลับ</a>";
    }else{
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_leave.php'>";
    
}}}}else{
    echo "<script>alert('มีการบันทึกการลาในวันที่เลือกแล้ว กรุณาตรวจสอบอีกครั้ง!!!    * หากต้องการลาต้องยกเลิกใบเดิมใบเดิม')</script>";
    echo "<meta http-equiv='refresh' content='0;url=./pre_leave.php'/>";
    exit();
}
}elseif ($method=='time_leave'){
//$leave_no=$_POST[leave_no]; 
$check_tleave = mysqli_query($db,"SELECT count(empno) amount
FROM timela
WHERE (SUBSTR(datela,1,7) = SUBSTR(NOW(),1,7))
and empno = $empno");
$Check_tleave=  mysqli_fetch_assoc($check_tleave);
if($Check_tleave['amount']>=5){
    echo "	<span class='glyphicon glyphicon-remove'> มีการลาครบกำหนด5ครั้งต่อเดือนแล้วครับ </span>";
    echo " <a href='pre_leave.php' >กลับ</a>";
}else{

        if($_SESSION['Status']=='ADMIN'){
$date_reg=insert_date($_POST['date_reg']);
    }else{
$date_reg=date('Y-m-d');        
    }
$date_l=insert_date($_POST['date_l']);
$time_s = $_POST['time_s'];
$time_e = $_POST['time_e'];
$amount = $_POST['amount'];
$reason_l = $_POST['reason_l'];
$stat_tl='N';
$regis='W';

$countla=$_POST["countla"];
$sumt=$_POST["sumt"];
$insert_print=  mysqli_query($db,"insert into print_tleave set empno='$empno',last_tleave='$countla',last_tamount='$sumt'");
if ($insert_print == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='pre_leave.php' >กลับ</a>";
    }else{

function removespecialchars($raw) {
    return preg_replace('#[^a-zA-Z0-9.-]#u', '', $raw);
}

if (!empty($_FILES["image"]["name"])) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "time_l/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
$regis_tleave=  mysqli_query($db,"select count from count where count_name='regis_tleave'");
$Regis_TLeave=  mysqli_fetch_assoc($regis_tleave);
$Ln=$Regis_TLeave['count']+1;
$Y=date('y')+43;
$leave_no="$Y/$Ln";
    $update_count=  mysqli_query($db,"update count set count='$Ln' where count_name='regis_tleave'");
    $insert_leave=  mysqli_query($db,"insert into timela set empno='$empno', vstdate='$date_reg', idno='$leave_no',
                                   comment='$reason_l',datela='$date_l',starttime='$time_s',endtime='$time_e',
                                       total='$amount',status='$stat_tl',depId='$depno',pics_t='$image',idAdmin='$adminId',regis_time='$regis' ");
    if ($insert_leave == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='pre_leave.php' >กลับ</a>";
    }else{
    $selec_timela= mysqli_query($db,"select id from timela where empno='$empno' and vstdate='$date_reg' ORDER BY id desc");
    $timeid=  mysqli_fetch_assoc($selec_timela);
    $update_time=mysqli_query($db,"update print_tleave set tleave_id='$timeid[id]' where last_tleave='$countla' and empno='$empno'");
    if ($update_time == false) {
        echo "<p>";
        echo "update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='pre_leave.php' >กลับ</a>";
    }else{
    
    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_leave.php'>";
    }}}}
}elseif ($method=='transfer') {
    $leave_no=$_POST['leave_no'];
    $date_reg = insert_date($_POST['date_reg']);
    $typel = $_POST['typel'];
    $amount = $_POST['amount'];
    $note = $_POST['note'];
    $date_s = insert_date($_POST['date_reg']);
    $date_e = insert_date($_POST['date_reg']);
    $reason_l = '';
    $add_conn = '';
    $tell = '';
    $cert = '';
    $image ='';
    $regis='Y';
    $insert_leave=  mysqli_query($db,"insert into work set enpid='$empno', reg_date='$date_reg', leave_no='$leave_no', begindate='$date_s', enddate='$date_e',
                                typela='$typel', amount='$amount', abnote='$reason_l', address='$add_conn', tel='$tell',
                                    check_comment='$cert', comment='$note', pics='$image', idAdmin='$adminId', statusla='Y',depId='$depno',regis_leave='$regis'");
include 'option/function_date.php';
if($date >= $bdate and $date <= $edate){
    $year = date('Y')-1;
}else{
    $year = date('Y');
}    
        $L_day=  mysqli_query($db,"select * from leave_day where empno='$empno' and fiscal_year='$year'");
        $L_Day=  mysqli_fetch_assoc($L_day);                            
     if($typel=='1'){
        $leave=$L_Day['L1']-$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L1='$leave' where empno='$empno' and fiscal_year='$year'");
      }  elseif($typel=='2'){
        $leave=$L_Day['L2']-$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L2='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='3'){
        $leave=$L_Day['L3']-$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L3='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='4'){
        $leave=$L_Day['L4']-$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L4='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='5'){
        $leave=$L_Day['L5']-$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L5='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='6'){
        $leave=$L_Day['L6']-$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L6='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='7'){
        $leave=$L_Day['L7']-$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L7='$leave' where empno='$empno' and fiscal_year='$year'");
      } 
    
    if ($insert_leave == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='main_leave.php' >กลับ</a>";
    }
    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=detial_leave.php?id=$empno'>";

}elseif($method=='edit_leave'){ 
    $Lno=$_POST['Lno'];
    $leave_no=$_POST['leave_no'];
$date_reg=insert_date($_POST['date_reg']);
$date_s=insert_date($_POST['date_s']);
$date_e=insert_date($_POST['date_e']);
    $typel = $_POST['typel'];
    $amount = $_POST['amount'];
    $reason_l = $_POST['reason_l'];
    $add_conn = $_POST['add_conn'];
    $tell = $_POST['tell'];
    $cert = $_POST['cert'];
    $note = $_POST['note'];
    
    function removespecialchars($raw) {
    return preg_replace('#[^a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "myfile/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
    if(!empty($image)){
        $del_photo=mysqli_query($db,"select pics from work where enpid='$empno' and workid='$Lno'");
                $del_photo=mysqli_fetch_assoc($del_photo);
                if(!empty($del_photo['pics'])){
                $location="myfile/".$del_photo['pics'];
                include 'function/delet_file.php';
                fulldelete($location);}
        
    $update_leave=  mysqli_query($db,"update work set enpid='$empno', reg_date='$date_reg', leave_no='$leave_no', begindate='$date_s', enddate='$date_e',
                                amount='$amount', abnote='$reason_l', address='$add_conn', tel='$tell',
                                    check_comment='$cert', comment='$note',idAdmin='$adminId',pics='$image'
                                where enpid='$empno' and workid='$Lno'");
    }else{
        $update_leave=  mysqli_query($db,"update work set enpid='$empno', reg_date='$date_reg', leave_no='$leave_no', begindate='$date_s', enddate='$date_e',
                                amount='$amount', abnote='$reason_l', address='$add_conn', tel='$tell',
                                    check_comment='$cert', comment='$note',idAdmin='$adminId'
                                where enpid='$empno' and workid='$Lno'");
    }
    
    $date_end=date('Y-m-d', strtotime("$date_e+1 days "));
        $update_event=mysqli_query($db,"update tbl_event set event_start='$date_s',event_end='$date_end' where empno='$empno' and workid='$Lno'");
        
        include 'option/function_date.php';
if($date >= $bdate and $date <= $edate){
    $beg_date="$y-10-01";
    $en_date="$Yy-09-30";
    $year = date('Y')-1;
}else{
    $beg_date="$Y-10-01";
    $en_date="$y-09-30";
    $year = date('Y');
}
    /*   $sql_leave=  mysql_query("select workid from work where enpid='$empno' and  typela='$typel' and statusla='Y' and begindate between '$beg_date' and '$en_date' ORDER BY workid desc");
$befor_leave=  mysql_fetch_assoc($sql_leave);
$befor_workid=$befor_leave['workid']; 
$update_print=  mysql_query("update print_leave set befor_workid='$befor_workid' where empno='$empno' and workid='$Lno'");*/

    if ($update_leave == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='main_leave.php' >กลับ</a>";
    }
    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_leave.php'>";
}elseif ($method=='edit_Tleave'){
$Lno=$_POST['Lno'];    
$leave_no=$_POST['leave_no'];    
$date_reg=insert_date($_POST['date_reg']);
$date_l=insert_date($_POST['date_l']);
$time_s = $_POST['time_s'];
$time_e = $_POST['time_e'];
$amount = $_POST['amount'];
$reason_l = $_POST['reason_l'];

function removespecialchars($raw) {
    return preg_replace('#[^a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "time_l/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}
if($image !=''){
    $del_photo=mysqli_query($db,"select pics_t from timela where empno='$empno' and id='$Lno'");
                $del_photo=mysqli_fetch_assoc($del_photo);
                if(!empty($del_photo['pics_t'])){
                $location="time_l/".$del_photo['pics_t'];
                include 'function/delet_file.php';
                fulldelete($location);}
    
$update_leave=  mysqli_query($db,"update timela set idno='$leave_no', vstdate='$date_reg', 
                                   comment='$reason_l',datela='$date_l',starttime='$time_s',endtime='$time_e',
                                       total='$amount',pics_t='$image'
                            where empno='$empno' and id='$Lno'");
}else{
    $update_leave=  mysqli_query($db,"update timela set idno='$leave_no', vstdate='$date_reg', 
                                   comment='$reason_l',datela='$date_l',starttime='$time_s',endtime='$time_e',
                                       total='$amount'
                            where empno='$empno' and id='$Lno'");
}
    if ($update_leave == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='main_leave.php' >กลับ</a>";
    }else{
    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=pre_leave.php'>";
    } 
}elseif ($method=='cancle_leave'){
    $typel=$_POST['typela'];
    $amount=$_POST['amount'];
    $Lno=$_POST['Lno'];
    $comment=$_POST['reason'];
    $status='N';
    date_default_timezone_set('Asia/Bangkok');
    $candate=  date('Y-m-d H:i:s');

    function removespecialchars($raw) {
    return preg_replace('#[^a-zA-Z0-9.-]#u', '', $raw);
}

if (trim($_FILES["image"]["name"] != "")) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], "cancle/" . removespecialchars(date("d-m-Y/") . "1" . $_FILES["image"]["name"]))) {
        $file1 = date("d-m-Y/") . "1" . $_FILES["image"]["name"];
        $image = removespecialchars($file1);
    }
}  else {
    $image ='';
}  
    $update_work=  mysqli_query($db,"update work set statusla='$status' where enpid='$empno' and workid='$Lno'");
    $in_cancle=  mysqli_query($db,"insert into cancle set workid='$Lno', cancledate='$candate', cancle_comment='$comment',
            admin_cancle='$adminId', pics_cancle='$image'");
           
    $delete_event=mysqli_query($db,"delete from tbl_event where empno='$empno' and workid='$Lno'");
    $delete_print_leave=mysqli_query($db,"delete from print_leave where empno='$empno' and workid='$Lno'");
    include 'option/function_date.php';
if($date >= $bdate and $date <= $edate){
    $year = date('Y')+1;
}else{
    $year = date('Y');
}    
        $L_day=  mysqli_query($db,"select * from leave_day where empno='$empno' and fiscal_year='$year'");
        $L_Day=  mysqli_fetch_assoc($L_day);
    if($typel=='1'){
        $leave=$L_Day['L1']+$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L1='$leave' where empno='$empno' and fiscal_year='$year'");
      }  elseif($typel=='2'){
        $leave=$L_Day['L2']+$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L2='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='3'){
        $leave=$L_Day['L3']+$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L3='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='4'){
        $leave=$L_Day['L4']+$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L4='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='5'){
        $leave=$L_Day['L5']+$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L5='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='6'){
        $leave=$L_Day['L6']+$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L6='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='7'){
        $leave=$L_Day['L7']+$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L7='$leave' where empno='$empno' and fiscal_year='$year'");
      }
    if ($in_cancle == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='main_leave.php' >กลับ</a>";
} }  elseif($method=='add_leave'){
    $year = $_POST['year']-543;
    $L1=$_POST['L1'];
    $L2=$_POST['L2'];
    $L3=$_POST['L3'];
    $L4=$_POST['L4'];
    $L5=$_POST['L5'];
    $L6=$_POST['L6'];
    $L7=$_POST['L7'];
    $sel_fiscal = mysqli_query($db, "SELECT fiscal_year FROM leave_day WHERE empno=$empno AND fiscal_year='$year'");
    $num_row = mysqli_num_rows($sel_fiscal);
if (empty($num_row)) {
    $insert_leave=  mysqli_query($db,"insert into leave_day set empno='$empno',emptype='$emptype',fiscal_year='$year', L1='$L1',L2='$L2',L3='$L3',L4='$L4',L5='$L5',L6='$L6',L7='$L7' ");
    if ($insert_leave == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_leave.php' >กลับ</a>";
         }else{
         echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=add_leave.php?id=$empno'>";}
}else{
    echo "<script>alert('มีการบันทึกปีงบประมาณ".$_POST['year']."แล้ว กรุณาตรวจสอบอีกครั้ง!!!')</script>";
    echo "<meta http-equiv='refresh' content='0;url=./add_leave.php?id=$empno'/>";
    exit();
}
}elseif($method=='edit_add_leave'){
    $year = $_POST['year']-543;
    $L1=$_POST['L1'];
    $L2=$_POST['L2'];
    $L3=$_POST['L3'];
    $L4=$_POST['L4'];
    $L5=$_POST['L5'];
    $L6=$_POST['L6'];
    $L7=$_POST['L7'];
    $update_add_leave=  mysqli_query($db,"update leave_day set L1='$L1',L2='$L2',L3='$L3',L4='$L4',L5='$L5',L6='$L6',L7='$L7'
            where empno='$empno' and fiscal_year='$year'");
    if ($update_add_leave == false) {
        echo "<p>";
        echo "update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='add_leave.php' >กลับ</a>";
         }
    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=add_leave.php?id=$empno'>";
}elseif ($method=='regis_leave') {
    $workid=$_POST['workid'];
    $regis='A';
    $leave_no=$_POST['leave_no'];
    $regis_date=date('Y-m-d');
    $update_regis=  mysqli_query($db,"update work set  leave_no='$leave_no',regis_leave='$regis',receiver='$adminId',regis_date='$regis_date'
            where enpid='$empno' and workid='$workid' ");
    if ($update_regis == false) {
        echo "<p>";
        echo "update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='receive_leave.php' >กลับ</a>";
         }
}elseif ($method=='check_leave') {
    $workid=$_POST['workid'];
    $regis=$_POST['confirm'];
    $typel=$_POST['typela'];
    $update_regis=  mysqli_query($db,"update work set regis_leave='$regis',confirmer='$adminId'
            where enpid='$empno' and workid='$workid' ");
    if($regis=='N'){
    $delete_event=mysqli_query($db,"delete from tbl_event where empno='$empno' and workid='$workid'");
    $amount_leave=  mysqli_query($db,"select amount from work where enpid='$empno' and workid='$workid'");
    $sql_amount=  mysqli_fetch_assoc($amount_leave);
    $amount=$sql_amount['amount'];
    include 'option/function_date.php';
if($date >= $bdate and $date <= $edate){
    $year = date('Y')-1;
}else{
    $year = date('Y');
}
        $L_day=  mysqli_query($db,"select * from leave_day where empno='$empno' and fiscal_year='$year'");
        $L_Day=  mysqli_fetch_assoc($L_day);
    if($typel=='1'){
        $leave=$L_Day['L1']+$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L1='$leave' where empno='$empno' and fiscal_year='$year'");
      }  elseif($typel=='2'){
        $leave=$L_Day['L2']+$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L2='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='3'){
        $leave=$L_Day['L3']+$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L3='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='4'){
        $leave=$L_Day['L4']+$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L4='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='5'){
        $leave=$L_Day['L5']+$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L5='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='6'){
        $leave=$L_Day['L6']+$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L6='$leave' where empno='$empno' and fiscal_year='$year'");
      }elseif($typel=='7'){
        $leave=$L_Day['L7']+$amount;
        $L_day2=  mysqli_query($db,"update leave_day set L7='$leave' where empno='$empno' and fiscal_year='$year'");
    }}
    if ($update_regis == false) {
        echo "<p>";
        echo "update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='receive_leave.php' >กลับ</a>";
         }
}elseif ($method=='regis_tleave') {
    $workid=$_POST['workid'];
    $regis='A';
    $leave_no=$_POST['leave_no'];
    $regis_date=date('Y-m-d');
    $update_regis=  mysqli_query($db,"update timela set  idno='$leave_no',regis_time='$regis',receivert='$adminId', regis_date='$regis_date' 
            where empno='$empno' and id='$workid' ");
    if ($update_regis == false) {
        echo "<p>";
        echo "update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='receive_leave.php' >กลับ</a>";
         }
}elseif ($method=='check_tleave') {
    $workid=$_POST['workid'];
    $regis=$_POST['confirm'];
    $update_regis=  mysqli_query($db,"update timela set regis_time='$regis',comfirmert='$adminId'
            where empno='$empno' and id='$workid' ");
    if ($update_regis == false) {
        echo "<p>";
        echo "update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='receive_leave.php' >กลับ</a>";
         }
}
?>
    </body>