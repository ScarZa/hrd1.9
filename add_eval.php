<?php @session_start(); ?>
<?php include 'connection/connect_i.php'; ?>
<?php
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
<LINK REL="SHORTCUT ICON" HREF="<?= $fol . $pic; ?>">
<!-- Bootstrap core CSS -->
<link href="option/css/bootstrap.css" rel="stylesheet">
<!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
<!-- Add custom CSS here -->
<link href="option/css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" href="option/font-awesome/css/font-awesome.min.css">
<!-- Page Specific CSS -->
<link rel="stylesheet" href="option/css/morris-0.4.3.min.css">
<link rel="stylesheet" href="option/css/stylelist.css">

<!--date picker-->
    <script src="option/js/jquery.min.js"></script>
    <script src="option/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom.js" type="text/javascript"></script>
    <link href="option/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom.css" rel="stylesheet" type="text/css"/>
    <link href="option/jquery-ui-1.11.4.custom/SpecialDateSheet.css" rel="stylesheet" type="text/css"/>
    <!--Data picker Thai-->
    <script src="js/DatepickerThai4.js" type="text/javascript"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="option/DataTables/dataTables.bootstrap4.css">
<!-- Select2--> 
<link href="option/select2/select2.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <script type="text/javascript">
            function inputDigits(sensor) {
                var regExp = /[0-9.-]$/;
                if (!regExp.test(sensor.value)) {
                    alert("กรอกตัวเลขเท่านั้นครับ");
                    sensor.value = sensor.value.substring(0, sensor.value.length - 1);
                }
            }
        </script>
        <!--scrip check ตัวอักษร-->
        <script type="text/javascript">
            function inputString(sensor) {
                var regExp = /[A-Za-zก-ฮะ-็่-๋์]$/;
                if (!regExp.test(sensor.value)) {
                    alert("กรอกตัวอักษรเท่านั้นครับ");
                    sensor.value = sensor.value.substring(0, sensor.value.length - 1);
                }
            }

        </script>
        
<form class="navbar-form navbar-left" role="form" action='prceval.php' enctype="multipart/form-data" method='post' onsubmit="return confirm('กรุณายืนยันการบันทึกอีกครั้ง !!!')">
    <?php
        $empno=$_GET['id'];
        
        $select_det=  mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,p2.posname as posi,e1.empno as empno,wh.emptype
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner JOIN work_history wh ON wh.empno=e1.empno
                            inner join department d1 on wh.depid=d1.depId
                            inner JOIN posid p2 ON p2.posId=wh.posid
                            inner join emptype e2 on e2.EmpType=wh.emptype
                                                        where e1.empno='$empno' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
                            $detial_l= mysqli_fetch_assoc($select_det);
            $method = isset($_GET['method'])?$_GET['method']:'';                
            if($method=='edit_eval'){
                $reseval_id= isset($_GET['reseval_id'])?$_GET['reseval_id']:'';
                $sql=  mysqli_query($db,"select * from resulteval where empno='$empno' and reseval_id=$reseval_id");
                $edit_person=mysqli_fetch_assoc($sql);
            }                
    ?>
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เพิ่มประวัติการประเมินและเงินเดือน</h3>
                    </div>
                <div class="panel-body">
                    <table align="center" width='100%'>
                        <thead>
              <tr>
                  <td width='50%' align="right" valign="top"><b>ชื่อ-นามสกุล : </b></td>
                  <td colspan="3">&nbsp;&nbsp;<?=$detial_l['fullname'];?></td>
              </tr>
              <tr>
                  <td align="right"><b>ฝ่าย-งาน : </b></td>
                  <td colspan="3">&nbsp;&nbsp; <?=$detial_l['dep'];?></td></tr>
              <tr>
                  <td align="right"><b>ตำแหน่ง : </b></td>
                  <td colspan="3">&nbsp;&nbsp; <?=$detial_l['posi'];?></td></tr>
                        </thead>
                    </table><br>
                    <div class="form-group"> 
                                <label>เลขที่คำสั่ง &nbsp;</label>
                                <input type="text" class="form-control" name="numdoc" value="<?= isset($edit_person['numdoc'])?$edit_person['numdoc']:''?>">
                            </div>
                    <div class="form-group"> 
                <label>วันที่อนุมัติ &nbsp;</label>
                <?php
 		if(!empty($method)){
 			$dateBegin=$edit_person['app_date'];
                        //$dateEnd_w=$edit_person['dateEnd_w'];
 			                 }else{
                        $dateBegin=date('Y-m-d');
                        //$dateEnd_w=date('Y-m-d');                   
                                         }
 		?>
                <script type="text/javascript">
                $(function() {
                $( "#datepicker" ).datepicker("setDate", new Date('<?=$dateBegin?>')); //Set ค่าวัน
                //$( "#datepicker2" ).datepicker("setDate", new Date('<?//=$dateEnd_w?>')); //Set ค่าวัน
                 });
                </script>
                <input type="text" id="datepicker"  placeholder='รูปแบบ 22/07/2557' class="form-control" name="app_date">
             	</div>
                    <div class="form-group"> 
                                <label>ปีงบประมาณ &nbsp;</label>
                                <?php if($method == 'edit_eval'){
                            echo "<input type='text' class='form-control' size='1' name='year' readonly value='".$edit_person['year']."'>";        
                                }else{ ?>
                                <select name='year' class="form-control select2" required>
                                <option value=''>กรุณาเลือกปีงบประมาณ</option>
                                <?php
                                for ($i = 2557; $i <= 2565; $i++) {
                                    echo "<option value='".$i."'>$i</option>";
                                }
                                ?>
                            </select>
                                <?php }?>
                            </div>
                    <div class="form-group"> 
                                <label>รอบการประเมิน &nbsp;</label>
                                <?php if($method == 'edit_eval'){
                            echo "<input type='text' class='form-control' size='1' readonly value='รอบที่ ".$edit_person['episode']."'><input type='hidden' name='episode' value='".$edit_person['episode']."'>";        
                                }else{ ?>
                                <select name='episode' class="form-control select2" required>
                                <option value=''>กรุณาเลือกรอบการประเมิน</option>
                                <option value='1'>รอบที่ 1</option>
                                <option value='2'>รอบที่ 2</option>
                           </select>
                                <?php }?>
                            </div>
                    <div class="form-group"> 
                                <label>ฐานการคำนวณ &nbsp;</label>
                                <input type="text" class="form-control" name="base_salary" value="<?= isset($edit_person['base_salary'])?$edit_person['base_salary']:''?>" onKeyUp="javascript:inputDigits(this);">
                            </div>
                    <div class="form-group"> 
                                <label>เงินเดือน &nbsp;</label>
                                <input type="text" class="form-control" name="salary" value="<?=isset($edit_person['salary'])?$edit_person['salary']:''?>" onKeyUp="javascript:inputDigits(this);">
                            </div>
                    <div class="form-group"> 
                                <label>เงินเดือนที่ปรับขึ้น &nbsp;</label>
                                <input type="text" class="form-control" name="salary_up" value="<?=isset($edit_person['salary_up'])?$edit_person['salary_up']:''?>" onKeyUp="javascript:inputDigits(this);">
                            </div>
                    <div class="form-group"> 
                                <label>ขึ้นร้อยละ &nbsp;</label>
                                <input type="text" class="form-control" name="percent" value="<?=isset($edit_person['percent'])?$edit_person['percent']:''?>" onKeyUp="javascript:inputDigits(this);">
                            </div>
                  <div class="form-group">
         			<label>ผลการประเมิน &nbsp;</label>
                                <select name="eval_id" id="eval_id" required  class="form-control select2" style="width: 100%;"> 
				<?php	
                                if($detial_l['emptype']==1){
                                    $sql = "eval_group=1 or eval_group=3 or eval_subgroup=1";
                                }elseif ($detial_l['emptype']==2) {
                                    $sql = "eval_group=2 or eval_group=3";
                                } else {
                                    $sql = "eval_group=1 and eval_subgroup=0 or eval_group=3";
                                }
                                $sql_eval = mysqli_query($db,"SELECT eval_id,eval_value FROM evaluation WHERE ".$sql);
				 echo "<option value=''>--ผลการประเมิน--</option>";
				 while( $result = mysqli_fetch_assoc( $sql_eval ) ){
          if($result['eval_id']==$edit_person['eval_id']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['eval_id']."' $selected>".$result['eval_value']." </option>";
				 } ?>
			 </select>
                  </div><input id="reas_hid" type="hidden" value="<?=$edit_person['reason_id']!=0?$edit_person['reason_id']:''?>">
                    <div class="form-group" id="reas"> 
                                <label>เหตุผลที่ไม่ได้รับการประเมิน &nbsp;</label>
                                <select name="reason_id" id="reason_id" class="form-control select2" style="width: 100%;"> 
				<?php	
                                $sql_reas = mysqli_query($db,"SELECT * FROM reason");
				 echo "<option value=''>--เหตุผล--</option>";
				 while( $result = mysqli_fetch_assoc( $sql_reas ) ){
          if($result['reason_id']==$edit_person['reason_id']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['reason_id']."' $selected>".$result['reason_value']." </option>";
				 } ?>
			 </select>
                            </div>
                    <br>
                    <div class="form-group" align="center">
                        <input type="hidden" name="empno" value="<?= $empno?>">
                        <?php if($method =='edit_eval'){?>
                        <input type="hidden" name="reseval_id" value="<?= $reseval_id?>">
                        <input type="hidden" name="method" value="update_eval">
                        <input type="submit" name="sumit" value="แก้ไข" class="btn btn-warning">
                        <?php }else{?>
                        <input type="hidden" name="method" value="add_eval">
                        <input type="submit" name="sumit" value="บันทึก" class="btn btn-success">
                        <?php }?>
                    </div>   
                    </div>
              </div>
          </div>
</div>
</form> 
        <script type="text/javascript">
            $(function (){
                if($("#reas_hid").val()==''){
                    $("div#reas").hide(0);
                }
        $("#eval_id").change(function() {
                    if($("#eval_id").val()==10){
                    $("#reas").show("fast");
                }else {
                    $("div#reas").hide(0);
                }
                });
            });
        </script>
<?php include_once 'footeri.php';?>