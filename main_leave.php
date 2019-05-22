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
include 'option/function_date.php';
    $empno=$_REQUEST['id'];
    $method = isset($_POST['method'])?$_POST['method']:isset($_GET['method'])?$_GET['method']:'';
    if($method=='edit'){
        $Lno=$_REQUEST['leave_no'];
         $edit_per=  mysqli_query($db,"select * from work where enpid='$empno' and workid='$Lno'");
        $edit_person=  mysqli_fetch_assoc($edit_per);
        
        $readonly='readonly';
    }else{
        $readonly='';
    }
?>
<div class="row">
          <div class="col-lg-12">
              <?php if($method=='edit'){?>
              <h1><font color='blue'>  แก้ไขการลา </font></h1> 
            <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="detial_leave.php?id=<?=$edit_person['enpid'];?>"><i class="fa fa-home"></i> รายละเอียดข้อมูลการลาของบุคลากร</a></li>
              <li class="active"><i class="fa fa-edit"></i> บันทึกการลา</li>
              </ol>
              <?php }else{?>
              <h1><font color='blue'>  บันทึกการลา </font></h1> 
            <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="pre_leave.php"><i class="fa fa-home"></i> ข้อมูลการลา</a></li>
              <li class="active"><i class="fa fa-edit"></i> บันทึกการลา</li>
              </ol>
              <?php }?>
              </div>
      </div>
<form class="navbar-form" role="form" action='prcleave.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading" align="center">
                    <h3 class="panel-title">บันทึกการลาของบุคลากร</h3>
                    </div>
                <div class="panel-body" align="center">
                    <div class="form-group" align="center">
                        <?php
                            $select_det=  mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,e1.depId as depno,p2.posname as posi,e1.empno as empno
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner JOIN work_history wh ON wh.empno=e1.empno
                                                        inner join department d1 on wh.depid=d1.depId
                                                        inner JOIN posid p2 ON p2.posId=wh.posid
                                                        where e1.empno='$empno' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
                            $detial_l= mysqli_fetch_assoc($select_det);

                            // $date = (date("Y")+543)."-".date("m-d");
                            // $Tyear = date("Y");
                            // $Oyear = date("Y")-1;
                            // $Fyear = date("Y")+1;
                            // if($date)
                     ?>
                        <table align="center" width='100%'>
                        <thead>
              <tr><td width='50%' align="right" valign="top"><b>ชื่อ-นามสกุล : &nbsp;</b></td><td width="50%"><?=$detial_l['fullname'];?></td></tr>
              <tr><td align="right"><b>ฝ่าย-งาน : &nbsp;</b></td><td><?=$detial_l['dep'];?></td></tr>
              <tr><td align="right"><b>ตำแหน่ง : &nbsp;</b></td><td><?=$detial_l['posi'];?></td></tr>
              <?php if($method=='edit' and $_SESSION['Status']=='ADMIN'){ ?>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
               <tr>
                  <td align="right"><b>เลขที่ใบลา : &nbsp;</b></td>
                  <td><div class="form-group">
                <input value='<?=$edit_person['leave_no'];?>' type="text" name="leave_no" id=leave_no" class="form-control" placeholder="เลขที่ใบลา">
                </div></td>
              </tr>
              <?php }?>
               <?php
 		if(!empty($method)){
 			$reg_date= $edit_person['reg_date'];
                        $begindate=edit_date($edit_person['begindate']);
                        $enddate= edit_date($edit_person['enddate']);
                        } else {
                        $reg_date=date('Y-m-d');
                        $begindate=date('Y-m-d');
                        $enddate=date('Y-m-d');
                        }
 		?>
                <script type="text/javascript">
                $(function() {
                $( "#datepicker" ).datepicker("setDate", new Date('<?=$reg_date?>')); //Set ค่าวัน
                $( "#datepicker2" ).datepicker("setDate", new Date('<?=$begindate?>')); //Set ค่าวัน
                $( "#datepicker3" ).datepicker("setDate", new Date('<?=$enddate?>')); //Set ค่าวัน
                 });
                </script>  
              <?php if($_SESSION['Status']=='ADMIN'){?>
              <tr>
                  <td align="right" valign="middle"><b>วันที่เขียนใบลา : &nbsp;</b></td>
                  <td>
                      <div class="form-group">
                      <input type="text" id="datepicker"  placeholder='รูปแบบ 22/07/2557' name="date_reg" class="form-control" required>
                      </div></td></tr>
              <?php }?>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>  
              <tr>
                <td align="right"><b>เลือกปีงบประมาณ : &nbsp;</b></td>
                <td><div class="form-group">
                                <select name='fiscal_year'  class="form-control">
                                    <option value=''>กรุณาเลือกปีงบประมาณ</option>
<?php

for ($i = 2558; $i <= 2565; $i++) {
  if((date("Y")+543)==$i){$selected='selected';}else{$selected='';}
    echo "<option value='$i' $selected>$i</option>";
}
?>
                                </select>                        
                            </div></td>
              </tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
              <tr><td align="right"><b>ประเภทการลา : &nbsp;</b></td><td>
                      <div class="form-group">
                           <?php  if($method=='edit'){
                               $sql = mysqli_query($db,"SELECT nameLa  FROM typevacation where idla='".$edit_person['typela']."'");
                               $result = mysqli_fetch_assoc( $sql );?>
                          <input type="text" name="typel_name" id="typel_name" class="form-control" value="<?= $result['nameLa']?>"  <?= $readonly?>>
                          <input type="hidden" name="typel" id="typel" value="<?= $result['idla']?>">
                           <?php }else{?>
                          <select name="typel" id="typel" class="form-control" required  <?= $readonly?>>
                              <?php	$sql = mysqli_query($db,"SELECT *  FROM typevacation order by idla  ");
				 echo "<option value=''>--เลือกประเภทการลา--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['idla']==$edit_person['typela']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['idla']."' $selected>".$result['nameLa']." </option>";
				 } ?>
			 </select>
                           <?php }?>
                      </div></td></tr>
              
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
              <tr><td align="right"><b>วันที่ลา : &nbsp;</b></td><td>
                      <div class="form-group">
                          <input name="date_s"  type="text" 
                                <?php  if($method=='edit'){ echo "value='$begindate'";}else{ echo "id='datepicker2'";}?>
                                 placeholder='รูปแบบ 22/07/2557' class="form-control" required <?= $readonly?>>
                      
                      
                      </div>                 <b> ถึง&nbsp;</b>
                    <div class="form-group">
                        <input name="date_e" type="text" 
                             <?php  if($method=='edit'){ echo "value='$enddate'";}else{ echo "id='datepicker3'";}?>
                             placeholder='รูปแบบ 22/07/2557' class="form-control" required <?= $readonly?>>
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
                        <input value='<?= isset($edit_person['amount'])?$edit_person['amount']:''?>' type="text" name="amount" id="amount" class="form-control" size="2" placeholder="จำนวน" onKeyUp="javascript:inputDigits(this);" required <?= $readonly?>>
                    </div><b> วัน&nbsp;&nbsp; <font color="red">** กรณีลาครึ่งวันให้ใส่ 0.5 วัน</font></b>
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
                        <textarea value='' name="reason_l" cols="50" rows=""  class="form-control" placeholder="เหตุผลการลา"><?= isset($edit_person['abnote'])?$edit_person['abnote']:''?></textarea>
                    </div>
                </td>
              </tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>สถานที่ติดต่อ : &nbsp;</b></td>
                <td>
                    <div class="form-group">
                        <textarea value='' class="form-control" name="add_conn" cols="50" rows="" placeholder="สถานที่ติดต่อ" ><?= isset($edit_person['address'])?$edit_person['address']:''?></textarea>
                    </div> 
                </td>
              </tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right"><b>เบอร์ทรศัพท์ : &nbsp;</b></td>
                <td>
                    <div class="form-group">
                        <input value='<?= isset($edit_person['tel'])?$edit_person['tel']:''?>' type="text" name="tell" id="tell" class="form-control" placeholder="เบอร์โทรศัพท์" maxlength="10" onKeyUp="javascript:inputDigits(this);">
                    </div>
                </td>
              </tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right"><b>ใบรับรองแพทย์ : &nbsp;</b></td>
                <td>
                    <select name="cert" id="cert" class="form-group">
                        <option value="1"> - </option>
                        <option value="2"> มี </option>
                        <option value="3"> ไม่มี </option>
                    </select>
                </td>
              </tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>หมายเหตุ : &nbsp;</b></td>
                <td>
                    <div class="form-group">
                        <textarea value='' class="form-control" name="note" cols="50" rows="" placeholder="หมายเหตุ"><?= isset($edit_person['comment'])?$edit_person['comment']:''?></textarea>
                    </div>
                </td>
              </tr>
              <tr>
                <th align="right">&nbsp;</th>
                <td>&nbsp;</td>
              </tr>
              <?php if($method=='edit'){ ?>
              <tr>
                <td align="right"><b>เพิ่มใบลา : &nbsp;</b></td>
                <td>
                    <div class="form-group">
                <input value='<?=$edit_person['pics'];?>' type="file" name="image"  id="image" class="form-control"/>
                    </div>
                </td>
              </tr>
              <?php }?>
                        </thead>
              </table>
                    </div><br><br>
                    <?php
                    if($method=='edit'){?>
                        <div class="form-group">
                        <input type="hidden" name="Lno" value="<?=$Lno;?>">
                        <input type="hidden" name="empno" value="<?=$detial_l['empno'];?>">
                        <input type="hidden" name="depno" value="<?=$detial_l['depno'];?>">
                    <input type="hidden" name="method" value="edit_leave">    
                    <input class="btn btn-warning" type="submit" name="submit" value="แก้ไข">
                    </div>
                    <?php }else{
                        
                    if($date >= $bdate and $date <= $edate){
                        if(empty($_GET['releave'])){
                        $sql_leave=  mysqli_query($db,"select w.typela as typela,ty.nameLa as namela, sum(w.amount) AS leave_type
                                            from work w 
                                            INNER JOIN typevacation ty on ty.idla=w.typela
                                            where w.statusla='Y' and w.enpid='$empno' and begindate BETWEEN '$y-10-01' and '$Yy-09-30' GROUP BY ty.idla");
                        } else {
                            $sql_leave=  mysqli_query($db,"select w.typela as typela,ty.nameLa as namela, sum(w.amount) AS leave_type
                                            from work w 
                                            INNER JOIN typevacation ty on ty.idla=w.typela
                                            where w.statusla='Y' and w.enpid='$empno' and begindate BETWEEN '$Y-10-01' and '$y-09-30' GROUP BY ty.idla");
                        }
                    }else{
                             $sql_leave=  mysqli_query($db,"select w.typela as typela,ty.nameLa as namela, sum(w.amount) AS leave_type
                                            from work w 
                                            INNER JOIN typevacation ty on ty.idla=w.typela
                                            where w.statusla='Y' and w.enpid='$empno' and begindate BETWEEN '$Y-10-01' and '$y-09-30' GROUP BY ty.idla");
                    }?>
                    <div class="form-group">
                        <table name="leave" border="1" cellspacing="" cellpadding="">
                            <tr>
                                <th colspan="2" align="center">สถิติการลา</th>
                            </tr>
                        <?php while($leave=mysqli_fetch_assoc($sql_leave)){?>
                            <tr>
                            <td><input type="text" name="typela[]" id="typela[]" value='<?=$leave['namela']?>' readonly=""></td>
                            <td><input type="text" name="leave_type[]" id="leave_type[]" value='<?=$leave['leave_type']?>' readonly="" size="1"> วัน</td>
                        </tr>
                        <?php }?>
                        </table><br>
                        <input type="hidden" name="empno" value="<?=$detial_l['empno'];?>">
                        <input type="hidden" name="depno" value="<?=$detial_l['depno'];?>">
                        <input type="hidden" name="method" value="leave">    
                    <input class="btn btn-success" type="submit" name="submit" value="บันทึก">
                    </div>
                    <?php }?>
                    </div>
                  </div>
              </div>
    </div>
</form>

<?php include_once 'footeri.php';?>