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
        <script type="text/javascript">
            function salaryPercent(){
                var res = ($('#salary_up').val()*100)/$('#base_salary').val();
                console.log(res)
                $('#percent').attr("value",res.toFixed(2));
            }
        </script>
        
<form class="navbar-form navbar-left" role="form" action='prcdeduct.php' enctype="multipart/form-data" method='post' onsubmit="return confirm('กรุณายืนยันการบันทึกอีกครั้ง !!!')">
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
            if($method=='edit_deduct'){
                $pf_id= isset($_GET['pf_id'])?$_GET['pf_id']:'';
                $sql=  mysqli_query($db,"select * from providentfund where empno='$empno' and pf_id=$pf_id");
                $edit_person=mysqli_fetch_assoc($sql);
            }          
    ?>
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เพิ่มประวัติกองทุนสำรองเลี้ยงชีพ</h3>
                    </div>
                <div class="panel-body">
                    <table align="center" width='100%'>
                        <thead>
              <tr>
                  <td width='40%' align="right" valign="top"><b>ชื่อ-นามสกุล : </b></td>
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
                <label>วันสมัครกองทุน &nbsp;</label>
                <?php 
                if(!empty($method)){
                    $regdate=$edit_person['regdate'];
                               //$dateEnd_w=$edit_person['dateEnd_w'];
                                     }else{
                               $regdate=date('Y-m-d');
                               //$dateEnd_w=date('Y-m-d');                   
                                                }
                ?>
                <script type="text/javascript">
                $(function() {
                $( "#datepicker" ).datepicker("setDate", new Date('<?=$regdate?>')); //Set ค่าวัน
                //$( "#datepicker2" ).datepicker("setDate", new Date('<?//=$dateEnd_w?>')); //Set ค่าวัน
                 });
                </script>
                <input type="text" id="datepicker"  placeholder='รูปแบบ 22-07-2557' class="form-control" name="regdate">
             	</div>
                 <div class="form-group"> 
                <label>วันที่เริ่มหักเงินงวดแรก &nbsp;</label>
                <?php 
                if(!empty($method)){
                    $deductdate=$edit_person['deductdate'];
                               //$dateEnd_w=$edit_person['dateEnd_w'];
                                     }else{
                               $deductdate=date('Y-m-d');
                               //$dateEnd_w=date('Y-m-d');                   
                                                }
                ?>
                <script type="text/javascript">
                $(function() {
                $( "#datepicker3" ).datepicker("setDate", new Date('<?=$deductdate?>')); //Set ค่าวัน
                //$( "#datepicker2" ).datepicker("setDate", new Date('<?//=$dateEnd_w?>')); //Set ค่าวัน
                 });
                </script>
                <input type="text" id="datepicker3"  placeholder='รูปแบบ 22-07-2557' class="form-control" name="deductdate">
             	</div>
               <div class="form-group"> 
                <label>วันที่ลาออกจากกองทุน &nbsp;</label>
                <?php 
                if(!empty($method)){
                    $enddate=$edit_person['enddate'];
                               //$dateEnd_w=$edit_person['dateEnd_w'];
                                     }else{
                               $enddate='';
                               //$dateEnd_w=date('Y-m-d');                   
                                                }
                ?>
                <script type="text/javascript">
                $(function() {
                    var method = $method;
                    if(method==''){
                        $( "#datepicker2" ).datepicker();
                    }else{
                        $( "#datepicker2" ).datepicker("setDate", new Date('<?=$enddate?>')); //Set ค่าวัน
                    }
                
                //$( "#datepicker2" ).datepicker("setDate", new Date('<?//=$dateEnd_w?>')); //Set ค่าวัน
                 });
                </script>
                <input type="text" id="datepicker2"  placeholder='รูปแบบ 22-07-2557' class="form-control" name="enddate">
             	</div>
               
                    <?php if(empty($method)){?>
                    <div class="form-group"> 
                                <label>แนบเอกสาร &nbsp;</label>
                                <input type="file" class="form-control" id='docs' name="docs" value="<?= isset($edit_person['docs'])?$edit_person['docs']:''?>">
                            </div>
                  <?php }?>
                    <br>
                    <div class="form-group" align="center">
                        <input type="hidden" name="empno" value="<?= $empno?>">
                        <?php if($method =='edit_deduct'){?>
                        <input type="hidden" name="pf_id" value="<?= $pf_id?>">
                        <input type="hidden" name="method" value="update_deduct">
                        <input type="submit" name="sumit" value="แก้ไข" class="btn btn-warning">
                        <?php }else{?>
                        <input type="hidden" name="method" value="add_deduct">
                        <input type="submit" name="sumit" value="บันทึก" class="btn btn-success">
                        <?php }?>
                    </div> 
                    </div>
              </div>
          </div>
</div>
</form> 
<?php include_once 'footeri.php';?>