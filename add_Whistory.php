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
<form class="navbar-form navbar-left" role="form" action='prchistory.php' enctype="multipart/form-data" method='post' onsubmit="return confirm('กรุณายืนยันการบันทึกอีกครั้ง !!!')">
    <?php
        $empno=$_REQUEST['id'];
        $his= isset($_REQUEST['his'])?$_REQUEST['his']:'';
        $method = isset($_REQUEST['method'])?$_REQUEST['method']:'';
        $select_det=  mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,p2.posname as posi,e1.empno as empno
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner join department d1 on e1.depid=d1.depId
                                                        inner join posid p2 on e1.posid=p2.posId
                                                        where e1.empno='$empno'");
                            $detial_l= mysqli_fetch_assoc($select_det);
            if($method=='edit_his'){
                $sql=  mysqli_query($db,"select * from work_history where empno='$empno' and his_id='$his'");
                $edit_person=mysqli_fetch_assoc($sql);
            }                
    ?>
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เพิ่มประวัติการทำงาน</h3>
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
         			<label>ตำแหน่ง &nbsp;</label>
                                <select name="dictation_id" id="dictation_id" required  class="form-control select2" style="width: 100%;"  onkeydown="return nextbox(event, 'position');"> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM dictation order by dictation_id");
				 echo "<option value=''>--เลือกชนิดคำสั่ง--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['dictation_id']==$edit_person['dictation_id']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['dictation_id']."' $selected>".$result['dictation_name']." </option>";
				 } ?>
			 </select>
			 </div>
                    <div class="form-group"> 
                <label>คำสั่งเลขที่ &nbsp;</label>
                <input value='<?= isset($edit_person['empcode'])?$edit_person['empcode']:''?>' type="text" class="form-control" name="order" id="order" placeholder="เลขที่คำสั่ง" onkeydown="return nextbox(event, 'position')">
             	</div>
                  <div class="form-group">
         			<label>ตำแหน่ง &nbsp;</label>
                                <select name="position" id="position" required  class="form-control select2" style="width: 100%;"  onkeydown="return nextbox(event, 'dep');"> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM posid order by posId");
				 echo "<option value=''>--ตำแหน่ง--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['posId']==$edit_person['posid']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['posId']."' $selected>".$result['posname']." </option>";
				 } ?>
			 </select>
			 </div>
                    <div class="form-group">
         			<label>ฝ่ายงาน &nbsp;</label>
 				<select name="dep" id="dep" required  class="form-control select2" style="width: 100%;" onkeydown="return nextbox(event, 'line');"> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM department order by depId");
				 echo "<option value=''>--ฝ่ายงาน--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['depId']==$edit_person['depid']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['depId']."' $selected>".$result['depName'] ."</option>";
				 } ?>
			 </select></div>
                                <div class="form-group">
			 </div>
                    <div class="form-group">
         			<label>สายงาน &nbsp;</label>
 				<select name="line" id="line" required  class="form-control"  onkeydown="return nextbox(event, 'pertype');"> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM empstuc order by Emstuc");
				 echo "<option value=''>--สายงาน--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['Emstuc']==$edit_person['empstuc']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['Emstuc']."' $selected>".$result['StucName']." </option>";
				 } ?>
			 </select>
			 </div>
                    <div class="form-group">
         			<label>ประเภทพนักงาน &nbsp;</label>
 				<select name="pertype" id="pertype" required  class="form-control"  onkeydown="return nextbox(event, 'educat');"> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM emptype order by EmpType");
				 echo "<option value=''>--ประเภทพนักงาน--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['EmpType']==$edit_person['emptype']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['EmpType']."' $selected>".$result['TypeName']." </option>";
				 } ?>
			 </select>
			 </div>
                    <div class="form-group">
         			<label>วุฒิการศึกษาที่บรรจุ &nbsp;</label>
 				<select name="educat" id="educat" required  class="form-control"  onkeydown="return nextbox(event, 'swday');"> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM education order by education");
				 echo "<option value=''>--วุฒิการศึกษาที่บรรจุ--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['education']==$edit_person['education']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['education']."' $selected>".$result['eduname']." </option>";
				 } ?>
			 </select>
			 </div>
                    <div class="form-group"> 
                <label>วันที่เริ่มปฏิบัติงาน &nbsp;</label>
                <?php
 		if(!empty($_GET['method'])){
 			$dateBegin=$edit_person['dateBegin'];
                        $dateEnd_w=$edit_person['dateEnd_w'];
 			                 }else{
                        $dateBegin=date('Y-m-d');
                        $dateEnd_w=date('Y-m-d');                   
                                         }
 		?>
                <script type="text/javascript">
                $(function() {
                $( "#datepicker" ).datepicker("setDate", new Date('<?=$dateBegin?>')); //Set ค่าวัน
                //$( "#datepicker2" ).datepicker("setDate", new Date('<?=$dateEnd_w?>')); //Set ค่าวัน
                 });
                </script>
                <input type="text" id="datepicker"  placeholder='รูปแบบ 22/07/2557' class="form-control" name="swday" id="swday" onkeydown="return nextbox(event, 'teducat')">
             	</div>
                    <?php if($method =='edit_his'){?>
                    <div class="form-group"> 
                <label>วันที่สิ้นสุดปฏิบัติงานในตำแหน่ง &nbsp;</label>
                <input type="text" id="datepicker2"  placeholder='รูปแบบ 01-01-2560' class="form-control" name="dateEnd_w" id="dateEnd_w" onkeydown="return nextbox(event, 'teducat')">
             	</div>
                    <?php }?>
                    <div class="form-group"> 
                                <label>แนบเอกสาร &nbsp;</label>
                                <input type="file" class="form-control" id='dict_docs' name="dict_docs" value="<?= isset($edit_person['dict_docs'])?$edit_person['dict_docs']:''?>">
                            </div><br>
                    
                    <div class="form-group" align="center">
                        <input type="hidden" name="empno" value="<?= $empno?>">
                        <?php if($method =='edit_his'){?>
                        <input type="hidden" name="his" value="<?= $his?>">
                        <input type="hidden" name="method" value="update_Whistory">
                        <input type="submit" name="sumit" value="แก้ไข" class="btn btn-warning">
                        <?php }else{?>
                        <input type="hidden" name="method" value="add_Whistory">
                        <input type="submit" name="sumit" value="บันทึก" class="btn btn-success">
                        <?php }?>
                    </div>   
                    </div>
              </div>
          </div>
</div>
</form> 
<?php include_once 'footeri.php';?>