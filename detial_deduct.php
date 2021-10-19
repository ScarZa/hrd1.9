<?php include 'header.php'; ?>
<?php
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<?php
if (!empty($_REQUEST['pf_id'])) { //ถ้า ค่า del_id ไม่เท่ากับค่าว่างเปล่า
    $pf_id=$_REQUEST['pf_id'];
    $sqle_del = "delete from providentfund where pf_id='$pf_id'";
    mysqli_query($db,$sqle_del) or die(mysqli_error($db));
//echo "ลบข้อมูล ID $del_id เรียบร้อยแล้ว";
}?>
<?php
$empno = isset($_REQUEST['id'])?$_REQUEST['id']:'';
if (!empty($_SESSION['emp'])) {
    $empno = $_SESSION['emp'];
} elseif ($_SESSION['Status'] == 'USER' or $_SESSION['Status']=='SUSER'  or $_SESSION['Status']=='USUSER') {
    $empno = $_SESSION['user'];
}
$name_detial = mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
                            d1.depName as dep,p2.posname as posi,e1.empno as empno
                            from emppersonal e1 
                            inner join pcode p1 on e1.pcode=p1.pcode 
                            INNER JOIN work_history wh ON wh.empno=e1.empno 
                            inner join department d1 on wh.depid=d1.depId 
                            inner join posid p2 on wh.posid=p2.posId 
                            where e1.empno='$empno' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w)) order by wh.his_id desc");


    $detial = mysqli_query($db,"SELECT pf.pf_id,pf.regdate,if(pf.enddate!='0000-00-00',pf.enddate,'')enddate,if(pf.deductdate!='0000-00-00',pf.deductdate,'')deductdate
    ,pf.docs,pf.recdate,CONCAT(em.firstname,' ',em.lastname)recorder
    FROM providentfund pf
    INNER JOIN emppersonal em on em.empno=pf.recorder
    WHERE pf.empno=$empno ORDER BY pf_id ASC");


$NameDetial = mysqli_fetch_assoc($name_detial);

include_once ('option/funcDateThai.php');
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  รายละเอียดกองทุนสำรองเลี้ยงชีพ </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            
            
<?php 
$method = isset($_REQUEST['method'])?$_REQUEST['method']:'';
if ($_SESSION['Status'] != 'USER') {
    if ($method == 'check_page') {
        $depno = $_REQUEST['depno'];
        ?> 

                    <li class="active"><a href="Lperson_report.php?depname=<?= $depno ?>"><i class="fa fa-edit"></i> สถิติการลาของของของบุคลากรหน่วยงาน</a></li>
                <?php } elseif ($method == 'check_page2') { ?>
                    <li class="active"><a href="statistics_leave.php"><i class="fa fa-edit"></i> สถิติการลา</a></li>
<?php }else{?>
                    <li><a href="pre_deduct.php"><i class="fa fa-edit"></i> ข้อมูลกองทุนสำรองเลี้ยงชีพ</a></li>
<?php }} ?>
            <li class="active"><i class="fa fa-edit"></i> รายละเอียดกองทุนสำรองเลี้ยงชีพ</li>
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
                 <a class="btn btn-success" download="report_person_leave.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br><br>
                <table  id="datatable" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><font size="3">ชื่อ นามสกุล :
                            <?= $NameDetial['fullname']; ?>
                            <br />
                            ตำแหน่ง :
<?= $NameDetial['posi']; ?>
                            <br />
                            ฝ่าย-งาน :
<?= $NameDetial['dep']; ?>
                            <br />
                            <?php
                                 include 'option/function_date.php';
                                ?>
                            </font></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="panel panel-primary"> 
                                <div class="panel-heading">
                                    <h3 class="panel-title">ข้อมูลกองทุนสำรองเลี้ยงชีพ</h3>
                                </div>
                                <div class="panel-body">
                                    <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                                                <?php if (isset($_SESSION['check_dl'])?$_SESSION['check_dl']:'' == 'check_detial_leave') { ?>
                                            <tr>
                                                <td colspan="9" align="center">ตั้งแต่วันที่
    <?= DateThai1($date01); ?>
                                                    ถึง
    <?= DateThai1($date02); ?></td>
                                            </tr>
<?php } ?>
                                        <tr align="center" bgcolor="#898888">
                                            <td align="center" width="2%"><b>ลำดับ</b></td>
                                            <td align="center" width="7%"><b>วันที่สมัคร</b></td>
                                            <td align="center" width="7%"><b>วันที่ลาออกกองทุน</b></td>
                                            <td align="center" width="7%"><b>วันที่เริ่มหักเงิน</b></td>
                                            <td align="center" width="10%"><b>เอกสาร</b></td>
                                            <?php if($_SESSION['Status']=='ADMIN'){?>
                                            <td align="center" width="7%"><b>วันที่บันทึก</b></td>
                                            <td align="center" width="20%"><b>ผู้บันทึก</b></td>
                                            <th align="center" width="5%">แก้ไข</th>
                                            <th align="center" width="5%">ลบ</th>
                                            <?php }?>

                                        </tr>
                                                    <?php
                                                    $i = 1;
                                                    while ($result = mysqli_fetch_assoc($detial)) {  ?>
                                            
                                                <td align="center"><?= $i ?></td>
                                                <td align="center"><?= DateThai1($result['regdate']); ?></td>
                                                <td align="center"><?= !empty($result['enddate'])?DateThai1($result['enddate']):''; ?></td>
                                                <td align="center"><?= DateThai1($result['deductdate']); ?></td>
                                                <td align="center"><a href="#" onclick="return popup('providentFundDocs.php?id=<?= $result['pf_id']?>', popup, 800, 1000);">
                                                        <img src='images/printer.png' width='30'></a></td>
                                                <?php if($_SESSION['Status']=='ADMIN'){?>
                                                <td align="center"><?= DateThai1($result['recdate']) ?></td>
                                                <td align="center"><?= $result['recorder']; ?></td>
                                                <td align="center"><a href="#" onclick="return popup('add_deduct.php?id=<?= $empno?>&method=edit_deduct&pf_id=<?= $result['pf_id']?>', popup, 500, 600);">
                                                        <img src='images/tool.png' width='30'></a></td>
                                                        <td align="center"><a href='detial_deduct.php?id=<?= $empno?>&pf_id=<?= $result['pf_id']?>' onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"><img src='images/bin1.png' width='30'></a></td>
                                                <?php }?>
                                            </tr>
    <?php $i++;
}
?>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
        </div>
    </div>
</div>
</div>
<?php include 'footeri.php'; ?>