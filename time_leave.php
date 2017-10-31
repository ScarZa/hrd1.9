<?php include_once 'header.php';?>
<?php if(empty($_SESSION['user'])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
<script type="text/javascript">
function nextbox(e, id) {
    var keycode = e.which || e.keyCode;
    if (keycode == 13) {
        document.getElementById(id).focus();
        return false;
    }
}
</script>
<?php
$empno=$_REQUEST['id'];
$method = isset($_POST['method'])?$_POST['method']:isset($_GET['method'])?$_GET['method']:'';
if($method=='edit_Tleave'){
        $Lno=$_REQUEST['leave_no'];
         $edit_per=  mysqli_query($db,"select * from timela where empno='$empno' and id='$Lno'");
        $edit_person=  mysqli_fetch_assoc($edit_per);
    }
    ?>
<div class="row">
          <div class="col-lg-12">
              <?php if($method=='edit_Tleave'){?>
              <h1><font color='blue'>  แก้ไขการลาชั่วโมง </font></h1> 
            <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="detial_leave.php?id=<?=$edit_person['empno'];?>"><i class="fa fa-home"></i> รายละเอียดข้อมูลการลาของบุคลากร</a></li>
              <li class="active"><i class="fa fa-edit"></i> บันทึกการลาชั่วโมง</li>
              </ol>
              <?php }else{?>
              <h1><font color='blue'>  บันทึกการลาชั่วโมง </font></h1> 
            <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="pre_leave.php"><i class="fa fa-home"></i> ข้อมูลการลา</a></li>
              <li class="active"><i class="fa fa-edit"></i> บันทึกการลาชั่วโมง</li>
              </ol>
              <?php }?>
              </div>
      </div>
<form class="navbar-form" role="form" action='prcleave.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading" align="center">
                    <h3 class="panel-title">บันทึกการลาชั่วโมงของบุคลากร</h3>
                    </div>
                <div class="panel-body" align="center">
                    <div class="form-group" align="center">
                        <?php
                        
                            $select_det=  mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,e1.depid as depno,p2.posname as posi,e1.empno as empno
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner JOIN work_history wh ON wh.empno=e1.empno
                                                        inner join department d1 on wh.depid=d1.depId
                                                        inner JOIN posid p2 ON p2.posId=wh.posid
                                                        where e1.empno='$empno' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
                            $detial_l= mysqli_fetch_assoc($select_det);
                        ?>
                        <table align="center" width='100%'>
                        <thead>
                            <tr><td width='50%' align="right" valign="top"><b>ชื่อ-นามสกุล : &nbsp;</b></td><td width="50%">&nbsp;<?=$detial_l['fullname'];?></td></tr>
              <tr><td align="right"><b>ฝ่าย-งาน : &nbsp;</b></td><td><?=$detial_l['dep'];?></td></tr>
              <tr><td align="right"><b>ตำแหน่ง : &nbsp;</b></td><td><?=$detial_l['posi'];?></td></tr>
              <?php if($method=='edit_Tleave'){?>              
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>

              <tr>
                <td align="right"><b>เลขที่ใบลา : &nbsp;</b></td>
                <td>
                    <div class="form-group">
                        <input value="<?= isset($edit_person['idno'])?$edit_person['idno']:''?>" type="text" name="leave_no" id=leave_no" class="form-control" placeholder="เลขที่ใบลา">
                </div>
                </td>
              </tr>
                <?php }?>
              <?php  
 		if(!empty($method)){
 			$vstdate= $edit_person['vstdate'];
                        $datela=$edit_person['datela'];
                        } else {
                        $vstdate=date('Y-m-d');
                        $datela=date('Y-m-d');
                        }
 		?>
                <script type="text/javascript">
                $(function() {
                $( "#datepicker" ).datepicker("setDate", new Date('<?=$vstdate?>')); //Set ค่าวัน
                $( "#datepicker2" ).datepicker("setDate", new Date('<?=$datela?>')); //Set ค่าวัน
                 });
                </script>
              <?php if($_SESSION['Status']=='ADMIN'){?>
              <tr><td align="right"><b>วันที่เขียนใบลา : &nbsp;</b></td>
                  <td>
                      <div class="form-group">
                             
                      <input name="date_reg" type="text" id="datepicker"  placeholder='รูปแบบ 22/07/2557' class="form-control" required>
                      </div></td></tr>
              <?php }?>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
              <tr><td align="right"><b>วันที่ลา : &nbsp;</b></td><td>
                      <div class="form-group">
                          <input name="date_l" type="text" id="datepicker2"  placeholder='รูปแบบ 22/07/2557' class="form-control" required>
                      </div></td></tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
              <tr><td align="right"><b>ตั้งแต่ : &nbsp;</b></td><td>
                      <div class="form-group">
                          <input value="<?= isset($edit_person['starttime'])?$edit_person['starttime']:''?>" type="time" name="time_s" id="time_s" placeholder="รูปแบบ 13:35" class="form-control" required>
                      
                      
                      </div>                 <b> ถึง</b>
                    <div class="form-group">
                        <input value="<?= isset($edit_person['endtime'])?$edit_person['endtime']:''?>" type="time" name="time_e" id="time_e" placeholder="รูปแบบ 13:35" class="form-control" required>
                    </div>
                </td>
                </tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td align="right"><b>รวมจำนวน : &nbsp;</b></td>
                <td>
                    <div class="form-group">
                        <input value="<?= isset($edit_person['total'])?$edit_person['total']:''?>" type="text" name="amount" id="amount" size="2" class="form-control" placeholder="จำนวน" onKeyUp="javascript:inputDigits(this);" required>
                    </div><b> ชัวโมง&nbsp;&nbsp; <font color="red">** กรณีลาครึ่งชั่วโมงไม่มีลาครึ่งชั่วโมง ต้องลาเต็มชั่วโมง</font></b>
                </td>
                </tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>เหตุผลการลา : &nbsp;</b></td>
                <td>
                    <div class="form-group">
                        <textarea value='' name="reason_l" cols="50" rows="" required class="form-control" placeholder="เหตุผลการลา"><?= isset($edit_person['comment'])?$edit_person['comment']:''?></textarea>
                     </div> 
                </td>
              </tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
              <?php if($method=='edit_Tleave'){?>
              <tr>
                <td align="right"><b>เพิ่มใบลา : &nbsp;</td>
                <td>
                  <div class="form-group">
                    <input type="file" name="image"  id="image" class="form-control"/>
                    </div>
                  </td>
              </tr>
              <?php } ?>
                        </thead>
              </table>
                    </div><br><br>
                    <?php if($method=='edit_Tleave'){?>
                    <div class="form-group">
                        <input type="hidden" name="Lno" value="<?=$edit_person['id'];?>">
                        <input type="hidden" name="empno" value="<?=$detial_l['empno'];?>">
                        <input type="hidden" name="depno" value="<?=$detial_l['depno'];?>">
                        <input type="hidden" name="method" value="edit_Tleave">    
                        <input class="btn btn-warning" type="submit" name="submit" value="แก้ไข">
                    </div>
                    <?php }else{
    include 'option/function_date.php';
    if($date >= $bdate and $date <= $edate){
        $sql_leave=  mysqli_query($db,"SELECT COUNT(total) as tcount,SUM(total) as tsum
                                                FROM timela
                                                WHERE empno='$empno' and `status`='N' AND 
                                                datela BETWEEN '$y-10-01' and '$Yy-09-30'");    
    }else{
                        $sql_leave=  mysqli_query($db,"SELECT COUNT(total) as tcount,SUM(total) as tsum
                                                FROM timela
                                                WHERE empno='$empno' and `status`='N' AND 
                                                datela BETWEEN '$Y-10-01' and '$y-09-30'");
    }?>
                    <div class="form-group">
                        <table name="leave" border="1" cellspacing="" cellpadding="">
                            <tr>
                                <th colspan="2" align="center">สถิติการลาชั่วโมง</th>
                            </tr>
                        <?php $leave=mysqli_fetch_assoc($sql_leave)?>
                            <tr>
                                <td><input type="text" name="countla" id="countla" value='<?=$leave['tcount']?>' readonly="" size="1"> ครั้ง</td>
                            <td><input type="text" name="sumt" id="sumt" value='<?=$leave['tsum']?>' readonly="" size="1"> ชั่วโมง</td>
                        </tr>
                        </table><br>
                        <input type="hidden" name="empno" value="<?=$detial_l['empno'];?>">
                        <input type="hidden" name="depno" value="<?=$detial_l['depno'];?>">
                        <input type="hidden" name="method" value="time_leave">    
                        <input class="btn btn-success" type="submit" name="submit" value="บันทึก">
                    </div>
                    <?php }?>
                    </div>
                  </div>
              </div>
    </div>
</form>

<?php include_once 'footeri.php';?>