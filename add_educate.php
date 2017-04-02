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

    </head>
    <body>
<form class="navbar-form navbar-left" role="form" action='prceducate.php' enctype="multipart/form-data" method='post' onsubmit="return confirm('กรุณายืนยันการบันทึกอีกครั้ง !!!')">
    <?php
    function edit_date($take_date)
                { $take_date=explode("-", $take_date);
 			$pyear=$take_date[0]+543;
 			$take_date="$take_date[2]-$take_date[1]-$pyear";
                         return $take_date; }
                         
        $empno=$_REQUEST['id'];
        $edu= isset($_REQUEST['edu'])?$_REQUEST['edu']:'';
        
        $select_det=  mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,p2.posname as posi,e1.empno as empno
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner join department d1 on e1.depid=d1.depId
                                                        inner join posid p2 on e1.posid=p2.posId
                                                        where e1.empno='$empno'");
                            $detial_l= mysqli_fetch_assoc($select_det);
            if(isset($_REQUEST['method'])?$_REQUEST['method']:''=='edit_edu'){
                $sql=  mysqli_query($db,"select * from educate where empno='$empno' and ed_id='$edu'");
                $edit_person=mysqli_fetch_assoc($sql);
            }                
    ?>
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เพิ่มประวัติการศึกษา</h3>
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
         			<label>วุฒิการศึกษา &nbsp;</label>
                                <select name="teducat" id="teducat" class="form-control" required onkeydown="return nextbox(event, 'major');"> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM education order by education");
				 echo "<option value=''>--วุฒิการศึกษา--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['education']==$edit_person['educate']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['education']."' $selected>".$result['eduname']." </option>";
				 } ?>
			 </select>
			 </div>
                    <div class="form-group"> 
                <label>สาขา/วิชาเอก &nbsp;</label>
                <input value='<?= isset($edit_person['major'])?$edit_person['major']:''?>' type="text" class="form-control" name="major" id="major" required placeholder="สาขา/วิชาเอก" onkeydown="return nextbox(event, 'inst')">
             	</div>
                    <div class="form-group"> 
                <label>สถาบันที่จบ &nbsp;</label>
                <input value='<?= isset($edit_person['institute'])?$edit_person['institute']:''?>' type="text" class="form-control" name="inst" id="inst" required placeholder="ชื่อสถาบัน" onkeydown="return nextbox(event, 'Graduation')">
             	</div>
                    <div class="form-group"> 
                <label>วันที่เข้าการศึกษา &nbsp;</label>
                <?php
 		if(!empty($_GET['method'])){
 			$start_date = $edit_person['start_date'];
                        $enddate = $edit_person['enddate'];
                        }else{
                        $start_date = date('Y-m-d');
                        $enddate = date('Y-m-d');    
                        }
 		?>
                <script type="text/javascript">
                $(function() {
                $( "#datepicker" ).datepicker("setDate", new Date('<?=$start_date?>')); //Set ค่าวัน
                $( "#datepicker2" ).datepicker("setDate", new Date('<?=$enddate?>')); //Set ค่าวัน
                 });
                </script>
                <input  type="text" id="datepicker"  placeholder='รูปแบบ 22/07/2557' class="form-control" name="Graduation" id="Graduation" onkeydown="return nextbox(event, 'statusw')">
                    
                </div>
                    <div class="form-group"> 
                <label>วันที่จบการศึกษา &nbsp;</label>
                <input type="text" id="datepicker2"  placeholder='รูปแบบ 22/07/2557' class="form-control" name="end_Graduation" id="Graduation" onkeydown="return nextbox(event, 'statusw')">
                    
                </div><br>
                    <div class="form-group" align="center">
                        <input type="hidden" name="empno" value="<?= $empno?>">
                        <input type="hidden" name="check_ed" value="1">
                        <?php if(isset($_REQUEST['method'])?$_REQUEST['method']:NULL=='edit_edu'){?>
                        <input type="hidden" name="edu" value="<?= $edu?>">
                        <input type="hidden" name="method" value="update_educate">
                        <input type="submit" name="sumit" value="แก้ไข" class="btn btn-warning">
                        <?php }else{?>
                        <input type="hidden" name="method" value="add_educate">
                        <input type="submit" name="sumit" value="บันทึก" class="btn btn-success">
                        <?php }?>
                    </div>   
                    </div>
              </div>
          </div>
</div>
</form> 