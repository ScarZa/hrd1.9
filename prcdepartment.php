<?php @session_start(); ?>
<?php if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
} ?>
<?php include'option/jquery.php'; ?>
<?php include_once 'header.php'; ?>
<meta charset="utf-8"> 
<?PHP
echo "<br><br><br><br>";

$name = isset($_POST['name']) ? $_POST['name'] : '';
$md_name = isset($_POST['md_name']) ? $_POST['md_name'] : '';
$method = isset($_POST['method']) ? $_POST['method'] : $_GET['method'];
if ($method == 'mupdate') {
    $dep_id = isset($_POST['dep_id'])?$_POST['dep_id']:'';
    $mdep_id = isset($_POST['mdep_id'])?$_POST['mdep_id']:'';
    $sqlUpdate = mysqli_query($db, "update department_group  SET dep_name='$name' 
		where main_dep='$mdep_id' ");


    if ($sqlUpdate == false) {
        echo "<p>";
        echo "Update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='Add_Department.php' >กลับ</a>";
    } else {
        echo "<p>&nbsp;</p>	";
        echo "<p>&nbsp;</p>	";
        echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
        echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>แก้ไขข้อมูลเรียบร้อย</center></a> 
								            </div>";
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_Department.php'>";
    }
} elseif ($method == 'update') {
    $dep_id = $_POST['dep_id'];
    $mdep_id = $_POST['mdep_id'];
    $sqlUpdate = mysqli_query($db, "update department  SET depName='$name',main_dep='$md_name' 
		where depId='$dep_id' and main_dep='$mdep_id' ");


    if ($sqlUpdate == false) {
        echo "<p>";
        echo "Update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='Add_Department.php' >กลับ</a>";
    } else {
        echo "<p>&nbsp;</p>	";
        echo "<p>&nbsp;</p>	";
        echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
        echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>แก้ไขข้อมูลเรียบร้อย</center></a> 
								            </div>";
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_Department.php'>";
    }
}//-----------------------------------------end update
elseif ($method == 'mdelete') {
    $dep_id = $_REQUEST['mdep_id'];
    $sqlDelete = mysqli_query($db, "delete from department_group  
		where main_dep='$dep_id' ");

    if ($sqlDelete == false) {
        echo "<p>";
        echo "Delete not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='Add_Department.php' >กลับ</a>";
    } else {
        echo "<p>&nbsp;</p>	";
        echo "<p>&nbsp;</p>	";
        echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
        echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>ลบข้อมูลเรียบร้อย</center></a> 
								            </div>";
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_Department.php'>";
    }
}//-----------------------------------------end delete
else if ($method == 'delete') {
    $dep_id = $_REQUEST['dep_id'];
    $sqlDelete = mysqli_query($db, "delete from department  
		where depId='$dep_id' ");

    if ($sqlDelete == false) {
        echo "<p>";
        echo "Delete not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='Add_Department.php' >กลับ</a>";
    } else {
        echo "<p>&nbsp;</p>	";
        echo "<p>&nbsp;</p>	";
        echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
        echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>ลบข้อมูลเรียบร้อย</center></a> 
								            </div>";
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_Department.php'>";
    }
}//-----------------------------------------end delete
elseif ($method == 'inser_mdep') {
    $sqlInsert = mysqli_query($db, "insert ignore into department_group  SET    dep_name='$name' ");

    if ($sqlInsert == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='Add_Department.php' >กลับ</a>";
    } else {
        echo "<p>&nbsp;</p>	";
        echo "<p>&nbsp;</p>	";
        echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
        echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>เพิ่มข้อมูลเรียบร้อย</center></a> 
								            </div>";
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_Department.php'>";
    }
} elseif ($method == 'inser_dep') {
    $sqlInsert = mysqli_query($db, "insert ignore into department SET depName='$name',main_dep='$md_name' ");

    if ($sqlInsert == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='Add_Department.php' >กลับ</a>";
    } else {
        echo "<p>&nbsp;</p>	";
        echo "<p>&nbsp;</p>	";
        echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
        echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>เพิ่มข้อมูลเรียบร้อย</center></a> 
								            </div>";
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=Add_Department.php'>";
    }
}
include_once 'footeri.php';
?>	





