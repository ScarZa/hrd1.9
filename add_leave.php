<?php include_once 'header.php'; ?>
<?php
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}

/*if (!empty($_REQUEST['work_id'])) {
    $work_id = $_REQUEST['work_id'];
    $sql_delw = "delete from work where workid ='$work_id'";
    mysqli_query($db,$sql_delw) or die(mysqli_error($db));
} elseif (!empty ($_REQUEST['time_id'])) {
    $time_id = $_REQUEST['time_id'];
    $sql_delt = "delete from timela where id='$time_id'";
    mysqli_query($db,$sql_delt) or die(mysqli_error($db));
}*/
$method = isset($_POST['method'])?$_POST['method']:isset($_GET['method'])?$_GET['method']:'';
$empno = $_GET['id'];
$year = isset($_GET['year'])?$_GET['year']:'';
$name_detial = mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
                            d1.depName as dep,p2.posname as posi,e1.empno as empno, e2.TypeName as typename,e2.EmpType as emptype
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode
                            inner JOIN work_history wh ON wh.empno=e1.empno
                            inner join department d1 on wh.depid=d1.depId
                            inner JOIN posid p2 ON p2.posId=wh.posid
                            inner join emptype e2 on e2.EmpType=wh.emptype
                            where e1.empno='$empno' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
$NameDetial = mysqli_fetch_assoc($name_detial);
$sql_tb = mysqli_query($db, "SELECT * FROM leave_day WHERE empno=".$empno." order by fiscal_year desc");

         if($method == 'edit'){
             $Sql_leave=  mysqli_query($db,"SELECT * FROM leave_day WHERE empno='$empno' and fiscal_year='$year'");
             $Sql_Leave=  mysqli_fetch_assoc($Sql_leave);
         }elseif ($method == 'delete') {
             $sql_del = mysqli_query($db,"DELETE FROM leave_day WHERE empno='$empno' AND fiscal_year='$year'");
}

include_once ('option/funcDateThai.php');
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  รายละเอียดข้อมูลการลาของบุคลากร </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><a href="pre_leave.php"><i class="fa fa-edit"></i> ข้อมูลการลา</a></li>
            <li class="active"><i class="fa fa-edit"></i> เพิ่มวันลา</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ข้อมูลบุคลากร</h3>
            </div>
            <div class="panel-body">
                <form class="navbar-form navbar-left" role="form" action='prcleave.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
                     
<font size="3">ชื่อ นามสกุล :
                            <?= $NameDetial['fullname']; ?>
                            <br />
                            ตำแหน่ง :
<?= $NameDetial['posi']; ?>
                            <br />
                            ฝ่าย-งาน :
<?= $NameDetial['dep']; ?>
                            <br />
                            ประเภทพนักงาน :
<?= $NameDetial['typename']; ?>
                            <br /><br />
                            </font>   
                            <div class="form-group"> 
                                <label>ปีงบประมาณ &nbsp;</label>
                                <?php if($method == 'edit'){
                            echo "<input type='text' class='form-control' size='1' name='year' readonly value='".($year+543)."'>";        
                                }else{ ?>
                                <select name='year'  class="form-control" required>
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
                            <label>ลาป่วย &nbsp;</label>
                            <input size="1" value='<?= isset($Sql_Leave['L1'])?$Sql_Leave['L1']:''?>' type="text" class="form-control" name="L1" id="L1" placeholder="ลาป่วย" onkeydown="return nextbox(event, 'L2')" required>
                            </div>
                                                        <div class="form-group"> 
                            <label>ลากิจ &nbsp;</label>
                            <input size="1" value='<?= isset($Sql_Leave['L2'])?$Sql_Leave['L2']:''?>' type="text" class="form-control" name="L2" id="L2" placeholder="ลากิจ" onkeydown="return nextbox(event, 'L3')" required>
                            </div>
                            <div class="form-group"> 
                            <label>ลาพักผ่อน &nbsp;</label>
                            <input size="1" value='<?= isset($Sql_Leave['L3'])?$Sql_Leave['L3']:''?>' type="text" class="form-control" name="L3" id="L3" placeholder="ลาพักผ่อน" onkeydown="return nextbox(event, 'L4')" required>
                            </div>
                            <div class="form-group"> 
                            <label>ลาคลอด &nbsp;</label>
                            <input size="1" value='<?= isset($Sql_Leave['L4'])?$Sql_Leave['L4']:''?>' type="text" class="form-control" name="L4" id="L4" placeholder="ลาคลอด" onkeydown="return nextbox(event, 'L5')">
                            </div>
                            <div class="form-group"> 
                            <label>ลาบวช &nbsp;</label>
                            <input size="1" value='<?= isset($Sql_Leave['L4'])?$Sql_Leave['L5']:''?>' type="text" class="form-control" name="L5" id="L5" placeholder="ลาบวช" onkeydown="return nextbox(event, 'L6')">
                            </div>
                            <div class="form-group"> 
                            <label>ลาศึกษาต่อ &nbsp;</label>
                            <input size="1" value='<?= isset($Sql_Leave['L4'])?$Sql_Leave['L6']:''?>' type="text" class="form-control" name="L6" id="L6" placeholder="ลาศึกษาต่อ" onkeydown="return nextbox(event, 'L7')">
                            </div>
                            <div class="form-group">
                            <label>ลาเลี้ยงดูบุตร &nbsp;</label>
                            <input size="1" value='<?= isset($Sql_Leave['L4'])?$Sql_Leave['L7']:''?>' type="text" class="form-control" name="L7" id="L7" placeholder="ลาเลี้ยงดูบุตร" onkeydown="return nextbox(event, 'Submit')">
                            </div>
                            <br><br>
                            <?php
         if($method == 'edit'){?>
                            <input type="hidden" name="method" id="method" value="edit_add_leave">
                             <input type="hidden" name="empno" id="method" value="<?=$empno?>">
                             <input type="hidden" name="emptype" id="method" value="<?= $NameDetial['emptype']; ?>">
                             <input class="btn btn-warning" type="submit" name="Submit" id="Submit" value="บันทึก">
        <?php }else{?>
                             <input type="hidden" name="method" id="method" value="add_leave">
                             <input type="hidden" name="empno" id="method" value="<?=$empno?>">
                             <input type="hidden" name="emptype" id="method" value="<?= $NameDetial['emptype']; ?>">
                             <input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก">
         <?php }?>
                </form>
                <div class="table-responsive">
                <table class="table table-responsive" align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                            <tr align="center" bgcolor="#898888">
                                <td align="center" width="6%"><b>ลำดับ</b></td>
                                <td align="center" width="10%"><b>ปีงบประมาณ</b></td>
                                <td align="center" width="10%"><b>ลาป่วย</b></td>
                                <td align="center" width="10%"><b>ลากิจ</b></td>
                                <td align="center" width="10%"><b>ลาพักผ่อน</b></td>
                                <td align="center" width="10%"><b>ลาคลอด</b></td>
                                <td align="center" width="10%"><b>ลาบวช</b></td>
                                <td align="center" width="10%"><b>ลาเลี้ยงดูบุตร</b></td>
                                <td align="center" width="10%"><b>ลาคลอด</b></td>
                                <td align="center" width="7%"><b>แก้ไข</b></td>
                                <td align="center" width="7%"><b>ลบ</b></td>
                            </tr>
                            <?php
                             $i=1;
                        while($result=mysqli_fetch_assoc($sql_tb)){?>
                                <tr>
                                <td align="center" width="6%"><?= $i?></td>
                                <td align="center" width="10%"><?= $result['fiscal_year']+543?></td>
                                <td align="center" width="10%"><?= $result['L1']?></td>
                                <td align="center" width="10%"><?= $result['L2']?></td>
                                <td align="center" width="10%"><?= $result['L3']?></td>
                                <td align="center" width="10%"><?= $result['L4']?></td>
                                <td align="center" width="10%"><?= $result['L5']?></td>
                                <td align="center" width="10%"><?= $result['L6']?></td>
                                <td align="center" width="10%"><?= $result['L7']?></td>
                                <td align="center" width="7%"><a href="add_leave.php?method=edit&&id=<?=$empno?>&&year=<?=$result['fiscal_year']?>"><img src='images/tool.png' width='30'></a></td>
                                <td align="center" width="7%"><a href="add_leave.php?method=delete&&id=<?=$empno?>&&year=<?=$result['fiscal_year']?>" title="ยืนยันการลบ" onclick="if(confirm('ยืนยันการลบออกจากรายการ ')) return true; else return false;"><img src='images/close.ico' width='30'></a></td>
                                </tr>
                        <?php $i++; }?>                
                </table>
                </div>
        </div>
    </div>
</div>
</div>
<?php include_once 'footeri.php'; ?>