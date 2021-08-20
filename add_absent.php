<?php include_once 'head.php'; 
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
if(isset($_GET['id'])){
$empno = $_GET['id'];
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
}
$method=isset($_GET['method'])?$_GET['method']:'';
$method_id= isset($_GET['method_id'])?$_GET['method_id']:'';
if ($method=='edit_absent') {
  $sql=mysqli_query($db,"select * from absent where empno=$empno and abs_id=$method_id");
}$detial= mysqli_fetch_assoc($sql);
include_once ('option/funcDateThai.php');
?>
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?= 'บันทึกการขาดราชการ'?></h3>
            </div>
            <div class="panel-body">

<font size="3">ชื่อ นามสกุล :
                            <?= $NameDetial['fullname']?>
                            <br />
                            ตำแหน่ง :
<?= $NameDetial['posi']?>
                            <br />
                            ฝ่าย-งาน :
<?= $NameDetial['dep']?>
                            <br />
                            ประเภทพนักงาน :
<?= $NameDetial['typename']?>
                            <p />
                            <form class="navbar-form navbar-left" role="form" action='prcabsent.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()"> 
                            <div class='row'><div class="form-group col-xs-12"> 
                            <label>วันที่เริ่ม &nbsp;</label>
                            <input type="text" class="form-control" name="beginabsdate" id="datepicker" placeholder="วันที่ลงเวลาสาย" required>
                            </div></div><p>
                            <div class='row'><div class="form-group col-xs-12"> 
                            <label>วันที่สิ้นสุด &nbsp;</label>
                            <input type="text" class="form-control" name="endabsdate" id="datepicker2" placeholder="วันที่ลงเวลาสาย" required>
                            </div></div><p>
                            <div class='row'><div class="form-group col-xs-12"> 
                            <div class="form-group">
                              <label for="">หมายเหตุ</label>
                              <textarea class="form-control" name="note" id="" rows=""><?= $detial['note'];?></textarea>
                            </div></div></div>
                            
                            <input type="hidden" name="empno" id="empno" value="<?=$empno?>">
                            <input type="hidden" name="popup" value="true">
                            
                            <?php  if ($method=='edit_absent') {  ?>
                              <input type='hidden' name='method' value='edit_absent'>
                              <input type='hidden' name='abs_id' value='<?= $detial['abs_id'];?>'>
                              <div align="center"><input class="btn btn-warning" type="submit" name="Submit" id="Submit" value="แก้ไข"></div>
                              <?php }else{ ?>
                                <input type='hidden' name='method' value='add_absent'>
                                <div align="center"><input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก"></div>
                              <?php } ?>
                             </form> 
                             <?php  
 		if(!empty($method)){
                        $beginabsdate = isset($detial['beginabsdate'])?$detial['beginabsdate']:'';
                        $endabsdate = isset($detial['endabsdate'])?$detial['endabsdate']:'';
                        } else {
                        $beginabsdate = date('Y-m-d');
                        $endabsdate = date('Y-m-d');
                        }
 		?>
                             <script type="text/javascript">
                            
                $(function() {
                $( "#datepicker" ).datepicker("setDate", new Date('<?=$beginabsdate?>')); //Set ค่าวัน
                $( "#datepicker2" ).datepicker("setDate", new Date('<?=$endabsdate?>')); //Set ค่าวัน
                 });
                </script>                           
        </div>
    </div>
</div>
<?php include_once 'footeri.php'; ?>