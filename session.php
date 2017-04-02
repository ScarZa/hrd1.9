<?PHP @session_start(); ?>
<META content="text/html; charset=utf8" http-equiv=Content-Type>
<DIV  align="center"><IMG src="images/tororo_exercise.gif" width="350"></DIV>
<?php   $method = isset($_POST['method'])?$_POST['method']:'';
if (isset($_POST['checkdate'])?$_POST['checkdate']:'' == '1' and $_POST['check_date01']!='')  {
    $_SESSION['checkdate'] = $_POST['checkdate'];
    $_SESSION['check_date01']=$_POST['check_date01'];
    $_SESSION['check_date02']=$_POST['check_date02'];
    echo "<meta http-equiv='refresh' content='0;url=statistics_leave.php' />";
}elseif (isset ($_POST['checkdate'])?$_POST['checkdate']:'' == '1' and $_POST['check_date01']=='') {
    $_SESSION['checkdate'] = '';
    $_SESSION['check_date01']= '';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=statistics_leave.php' />";

    
}elseif ($method=='check_date_cancle' and $_POST['check_date01']!='') {
    $_SESSION['check_cancle']=$method;
    $_SESSION['check_date01']=$_POST['check_date01'];
    $_SESSION['check_date02']=$_POST['check_date02'];
    echo "<meta http-equiv='refresh' content='0;url=conclude_cancle.php' />";
}elseif ($method=='check_date_cancle' and $_POST['check_date01']=='') {
    $_SESSION['check_cancle'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=conclude_cancle.php' />";

    
}elseif ($method=='check_trainin' and $_POST['check_date01']!='') {
    $_SESSION['check_trainin']=$method;
    $_SESSION['check_date01']=$_POST['check_date01'];
    $_SESSION['check_date02']=$_POST['check_date02'];
    echo "<meta http-equiv='refresh' content='0;url=pre_trainin.php' />";
}elseif ($method=='check_trainin' and $_POST['check_date01']=='') {
    $_SESSION['check_trainin'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=pre_trainin.php' />";

    
}elseif ($method=='check_pro_trainin' and $_POST['check_date01']!='') {
    $_SESSION['check_pro']=$method;
    $_SESSION['check_date01']=$_POST['check_date01'];
    $_SESSION['check_date02']=$_POST['check_date02'];
    echo "<meta http-equiv='refresh' content='0;url=statistics_trainin.php' />";
}elseif ($method=='check_pro_trainin' and $_POST['check_date01']=='') {
    $_SESSION['check_pro'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=statistics_trainin.php' />";

    
}elseif ($method=='check_trainout' and $_POST['check_date01']!='') {
    $_SESSION['check_trainout']=$method;
    $_SESSION['check_date01']=$_POST['check_date01'];
    $_SESSION['check_date02']=$_POST['check_date02'];
    echo "<meta http-equiv='refresh' content='0;url=pre_trainout.php' />";
}elseif ($method=='check_trainout' and $_POST['check_date01']=='') {
    $_SESSION['check_trainout'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=pre_trainout.php' />";

    
}elseif ($method=='check_pro_trainout' and $_POST['check_date01']!='') {
    $_SESSION['check_out']=$method;
    $_SESSION['check_date01']=$_POST['check_date01'];
    $_SESSION['check_date02']=$_POST['check_date02'];
    echo "<meta http-equiv='refresh' content='0;url=statistics_trainout.php' />";
}elseif ($method=='check_pro_trainout' and $_POST['check_date01']=='') {
    $_SESSION['check_out'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=statistics_trainout.php' />";

    
}elseif ($method=='check_statistics_trainout' and $_POST['check_date01']!='') {
    $_SESSION['check_stat']=$method;
    $_SESSION['check_date01']=$_POST['check_date01'];
    $_SESSION['check_date02']=$_POST['check_date02'];
    $emp=$_POST['empno'];
    
    echo "<meta http-equiv='refresh' content='0;url=detial_trainin.php?&id=$emp&method=check' />";
}elseif ($method=='check_statistics_trainout' and $_POST['check_date01']=='') {
    $_SESSION['check_stat'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    $emp=$_POST['empno'];
    echo "<meta http-equiv='refresh' content='0;url=detial_trainin.php?&id=$emp&method=check' />";

    
}elseif ($method=='check_detial_leave' and $_POST['check_date01']!='') {
    $_SESSION['check_dl']=$method;
    $_SESSION['leave_date1']=$_POST['check_date01'];
    $_SESSION['leave_date2']=$_POST['check_date02'];
    $emp=$_POST['empno'];
    echo "<meta http-equiv='refresh' content='0;url=detial_leave.php?&id=$emp' />";
}elseif ($method=='check_detial_leave' and $_POST['check_date01']=='') {
    $_SESSION['check_dl'] = '';
    $_SESSION['leave_date1']='';
    $_SESSION['leave_date2']='';
    $emp=$_POST['empno'];
    echo "<meta http-equiv='refresh' content='0;url=detial_leave.php?&id=$emp' />";

    
}elseif ($method=='check_receive' and $_POST['check_date01']!='') {
    $_SESSION['check_rec']=$method;
    $_SESSION['check_date01']=$_POST['check_date01'];
    $_SESSION['check_date02']=$_POST['check_date02'];
    echo "<meta http-equiv='refresh' content='0;url=receive_leave.php' />";
}elseif ($method=='check_receive' and $_POST['check_date01']=='') {
    $_SESSION['check_rec'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=receive_leave.php' />";

    
}elseif ($method=='check_receive_app' and $_POST['check_date01']!='') {
    $_SESSION['check_rec']=$method;
    $_SESSION['check_date01']=$_POST['check_date01'];
    $_SESSION['check_date02']=$_POST['check_date02'];
    echo "<meta http-equiv='refresh' content='0;url=receive_trainout.php' />";
}elseif ($method=='check_receive_app' and $_POST['check_date01']=='') {
    $_SESSION['check_rec'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=receive_trainout.php' />";

    
}elseif ($method=='Lperson_date' and $_POST['take_date01']!='') {
    $_SESSION['check_Lperson']=$method;
    $_SESSION['check_date01']=$_POST['take_date01'];
    $_SESSION['check_date02']=$_POST['take_date02'];
    echo "<meta http-equiv='refresh' content='0;url=Lperson_report.php' />";
}elseif ($method=='Lperson_date' and $_POST['take_date01']=='') {
    $_SESSION['check_Lperson'] = '';
    $_SESSION['check_date01']='';
    $_SESSION['check_date02']='';
    echo "<meta http-equiv='refresh' content='0;url=Lperson_report.php' />";

    
}elseif ($method=='Lperson_dep' and $_POST['dep']!='') {
    $_SESSION['dep_Lperson']=$method;
    $depname=$_POST['dep'];
    echo "<meta http-equiv='refresh' content='0;url=Lperson_report.php?&depname=$depname' />";
}elseif ($method=='Lperson_dep' and $_POST['dep']=='') {
    $_SESSION['dep_Lperson'] = '';
    $_SESSION['depname']='';
    echo "<meta http-equiv='refresh' content='0;url=Lperson_report.php' />";

    
}
 ?>   