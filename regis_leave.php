<?php @session_start(); ?>
<?php include_once 'connection/connect_i.php';?>
<?php
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
$method = isset($_POST['method'])?$_POST['method']:isset($_GET['method']);
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
<LINK REL="SHORTCUT ICON" HREF="images/logo.png">
<!-- Bootstrap core CSS -->
<link href="option/css/bootstrap.css" rel="stylesheet">
<!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
<!-- Add custom CSS here -->
<link href="option/css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" href="option/font-awesome/css/font-awesome.min.css">
<script src="option/js/jquery.min.js"></script>
<!-- Page Specific CSS -->
<link rel="stylesheet" href="option/css/morris-0.4.3.min.css">
<link rel="stylesheet" href="option/css/stylelist.css">
<!-- Select2--> 
<link href="option/select2/select2.min.css" rel="stylesheet" type="text/css"/>
</head>
    <body>            
        <form class="navbar-form navbar-left" role="form" action='prcleave.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
        <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
           <?php if($method=='confirm_leave'){?> 
            <div class="panel-heading" align="center">
                <h3 class="panel-title"> ทรัพยากรบุคคลรับใบลา</h3>
            </div>
            <div class="panel-body" align='center'>
                <div class="well well-sm">
                <b>ยืนยันการอนมัติใบลา</b>
                <div class="form-group">
                    <input type="radio" name="confirm" id="confirm" value="Y" required="" checked>&nbsp;&nbsp; รับ<br> 
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="confirm" id="confirm" value="N" required="">&nbsp;&nbsp; ไม่รับ
                </div>
                </div>
                <?php }else{?>
                 <div class="panel-heading" align="center">
                <h3 class="panel-title"> อนุมัติใบลา</h3>
            </div>
            <div class="panel-body" align='center'>
            <div class="well well-sm">
                <b>ยืนยันการรับใบลา</b>
                <div class="form-group">
                    <input type="radio" name="confirm" id="confirm" value="A" required="">&nbsp;&nbsp; อนุมัติ<br> 
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="confirm" id="confirm" value="N" required="">&nbsp;&nbsp; ไม่อนุมัติ
                </div>
                </div>
                <?php }?>
                                        <?php include_once ('option/funcDateThai.php');
                                        
                                        $empno=$_REQUEST['id'];
                                        $Lno=$_REQUEST['Lno'];
                            $select_det=  mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,p2.posname as posi,e1.empno as empno,w.*
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner join department d1 on e1.depid=d1.depId
                                                        inner join posid p2 on e1.posid=p2.posId
                                                        inner join work w on e1.empno=w.enpid
                                                        where e1.empno='$empno' and w.workid='$Lno'");
                            $detial_l= mysqli_fetch_assoc($select_det);
                            $idAdmin=$detial_l['idAdmin'];
                            $select_admin=mysqli_query($db,"select concat(e.firstname,' ',e.lastname) as adminname
                                                        from emppersonal e
                                                        inner join work w on e.empno=w.idAdmin
                                                        where w.idAdmin='$idAdmin'");
                            $detial_admin= mysqli_fetch_assoc($select_admin);        
                        ?>
                <b>เลขที่ใบลา : &nbsp;</b>
                <div class="form-group">
                <input value='<?=$detial_l['leave_no'];?>' type="text" name="leave_no" id=leave_no" class="form-control" placeholder="เลขที่ใบลา" required size="5">
                </div>
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
              <tr>
                  <td align="right"><b>วันที่เขียนใบลา : </b></td>
                  <td  colspan="3">&nbsp;&nbsp; <?=DateThai1($detial_l['reg_date']);?></td>
              </tr>
              <tr>
                  <td align="right"><b>ประเภทการลา : </b></td>
                  <td colspan="3">&nbsp;&nbsp; <?php	$sql = mysqli_query($db,"SELECT *  FROM typevacation where idla='".$detial_l['typela']."'");
				 $result = mysqli_fetch_assoc( $sql );
                                echo $result['nameLa'];
				 ?>
                  </td>
              </tr>
              <tr><td align="right"><b>วันที่ลา : </b></td>
                  <td  colspan="3">&nbsp;&nbsp; <?=DateThai1($detial_l['begindate']);?> <b>ถึง</b> <?=DateThai1($detial_l['enddate']);?></td>
              </tr>
              <tr>
                <td align="right"><b>รวมจำนวน : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['amount'];?>&nbsp; <b>วัน</b></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>เหตุผลการลา : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['abnote'];?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>สถานที่ติดต่อ : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['address'];?></td>
              </tr>
              <tr>
                <td align="right"><B>เบอร์ทรศัพท์ : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['tel'];?></td>
              </tr>
              <tr>
                <td align="right"><b>ใบรับรองแพทย์ : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?php 
                    if($detial_l['check_comment']==1){
                        echo '-';
                    }elseif ($detial_l['check_comment']==2) {
                        echo 'มี';  
                      }elseif ($detial_l['check_comment']==3) {
                        echo 'ไม่มี';
                      }
?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>หมายเหตุ : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['comment'];?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>ผู้บันทึก : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_admin['adminname'];?></td>  
              </tr>
              <?php if($method!='confirm_leave'){?> 
              <tr>
                <td align="right" valign="top"><b>ผู้ปฏิบัติงานแทน : </b></td>
                <td colspan="3">&nbsp;&nbsp; <select name="surrogate" id="surrogate" required  class="form-control select2" style="width: 90%" onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = mysqli_query($db,"SELECT empno,concat(firstname,' ',lastname) as fullname  FROM emppersonal order by empno ");
				 echo "<option value=''>-เลือกบุคลากร-</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          //if($result['empno']==$resultGet['manager']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['empno']."'>".$result['fullname']."</option>";
				 } ?>
			 </select></td>
            </tr>
                <?php }?>
                        </thead>
                        </table><br>
                        <center>
                        <input type="hidden" name="popup" value="true">    
                        <input type="hidden" name="empno" value="<?=$detial_l['empno'];?>">
                        <input type="hidden" name="workid" value="<?=$detial_l['workid'];?>">
                        <?php if($method=='confirm_leave'){?> 
                    <input type="hidden" name="method" value="check_leave">
                    <input type="hidden" name="typela" value="<?=$detial_l[typela];?>">
                    <input class="btn btn-success" type="submit" name="submit" value="รับใบลา">
                        <?php }else{?>
                    <input type="hidden" name="method" value="regis_leave">    
                    <input class="btn btn-success" type="submit" name="submit" value="อนุมัติ">
                        <?php }?>
                    </center>
           </div>
            
            </div>
        </div>
            </div>
            </div>
        </form>
<?php include_once 'footeri.php';?>