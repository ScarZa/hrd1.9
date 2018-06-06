<?php include 'header.php'; ?>
<?php
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<?php
if (!empty($_REQUEST['reseval_id'])) { //ถ้า ค่า del_id ไม่เท่ากับค่าว่างเปล่า
    $reseval_id=$_REQUEST['reseval_id'];
    $sqle_del = "delete from resulteval where reseval_id='$reseval_id'";
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


    $detial = mysqli_query($db,"SELECT re.reseval_id,re.numdoc,re.app_date, re.year,re.episode,re.base_salary,re.salary,re.salary_up,re.percent
,e.eval_value,if(re.reason_id!=0,rs.reason_value,'') as reason_value
,re.rec_date,CONCAT(em.firstname,' ',em.lastname)fullname
FROM resulteval re
INNER JOIN emppersonal em on em.empno=re.recorder
INNER JOIN evaluation e on e.eval_id=re.eval_id
LEFT OUTER JOIN reason rs on rs.reason_id=re.reason_id
WHERE re.empno=$empno ORDER BY re.year ASC,re.episode ASC");


$NameDetial = mysqli_fetch_assoc($name_detial);

include_once ('option/funcDateThai.php');
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  รายละเอียดประวัติการประเมินและเงินเดือน </font></h1> 
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
                    <li><a href="pre_eval.php"><i class="fa fa-edit"></i> ข้อมูลประวัติการประเมิน/เงินเดือน</a></li>
<?php }} ?>
            <li class="active"><i class="fa fa-edit"></i> รายละเอียดข้อมูลประวัติการทำงานของบุคลากร</li>
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
                                    <h3 class="panel-title">ข้อมูลการประเมินและเงินเดือน</h3>
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
                                            <td align="center" width="5%"><b>ลำดับ</b></td>
                                            <td align="center" width="7%"><b>เลขที่คำสั่ง</b></td>
                                            <td align="center" width="7%"><b>วันที่อนุมัติ</b></td>
                                            <td align="center" width="7%"><b>ปีงบประมาณ</b></td>
                                            <td align="center" width="7%"><b>รอบที่</b></td>
                                            <td align="center" width="10%"><b>ฐานในการคำนวณ</b></td>
                                            <td align="center" width="10%"><b>เงินเดือน</b></td>
                                            <td align="center" width="7%"><b>เงินที่ปรับเพิ่ม</b></td>
                                            <td align="center" width="7%"><b>ร้อยละ</b></td>
                                            <td align="center" width="7%"><b>ผลการประเมิน</b></td>
                                            <td align="center" width="7%"><b>เหตุผล</b></td>
                                            <?php if($_SESSION['Status']=='ADMIN'){?>
                                            <td align="center" width="7%"><b>วันที่บันทึก</b></td>
                                            <td align="center" width="20%"><b>ผู้บันทึก</b></td>
                                            <th align="center" width="5%">แก้ไข</th>
                                            <th align="center" width="5%">ลบ</th>
                                            <?php }?>

                                        </tr>
                                                    <?php
                                                    $i = 1;
                                                    while ($result = mysqli_fetch_assoc($detial)) {
                                                        
                                                        if($result['episode']==1){
                                                            $episode = '1 เม.ย. '.$result['year'];
                                                        }else if($result['episode']==2) {
                                                            $episode = '1 ต.ค. '.($result['year']+1);
                                            }
                                                        ?>
                                            <tr>
                                                <td align="center"><?= $i ?></td>
                                                <td align="center"><?= $result['numdoc']; ?></td>
                                                <td align="center"><?= DateThai1($result['app_date']); ?></td>
                                                <td align="center"><?= $result['year']; ?></td>
                                                <td align="center"><?= $episode; ?></td>
                                                <td align="center"><?= number_format($result['base_salary']); ?></td>
                                                <td align="center"><?= number_format($result['salary']); ?></td>
                                                <td align="center"><?= $result['salary_up']; ?></td>
                                                <td align="center"><?= $result['percent']; ?> %</td>
                                                <td align="center"><?= $result['eval_value']; ?></td>
                                                <td align="center"><?= $result['reason_value']; ?></td>
                                                <?php if($_SESSION['Status']=='ADMIN'){?>
                                                <td align="center"><?= DateThai1($result['rec_date']) ?></td>
                                                <td align="center"><?= $result['fullname']; ?></td>
                                                <td align="center"><a href="#" onclick="return popup('add_eval.php?id=<?= $empno?>&amp;method=edit_eval&amp;reseval_id=<?= $result['reseval_id']?>', popup, 500, 750);">
                                                        <img src='images/tool.png' width='30'></a></td>
                                                        <td align="center"><a href='detial_eval.php?id=<?= $empno?>&reseval_id=<?= $result['reseval_id']?>' onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"><img src='images/bin1.png' width='30'></a></td>
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