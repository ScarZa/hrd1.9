<?php include_once 'header.php';
function backup_tables($db,$tables = '*')
{
    //get all of the tables
    if($tables == '*')
    {
        $tables = array();
        $result = mysqli_query($db,'SHOW TABLES');
        while($row = mysqli_fetch_row($result))
        {
            $tables[] = $row[0];
        }
    }
    else
    {
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }
    $return='';
    //cycle through
    foreach($tables as $table)
    {
        $result = mysqli_query($db,'SELECT * FROM '.$table);
        $num_fields = mysqli_num_fields($result);

        $return.= 'DROP TABLE IF EXISTS '.$table.';';
        $row2 = mysqli_fetch_row(mysqli_query($db,'SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";

        for ($i = 0; $i < $num_fields; $i++) 
        {
            while($row = mysqli_fetch_row($result))
            {
                $return.= 'INSERT IGNORE INTO '.$table.' VALUES(';
                for($j=0; $j<$num_fields; $j++) 
                {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_replace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                    if ($j<($num_fields-1)) { $return.= ','; }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }

    //save file
    $handle = fopen('backupDB/db-backup-'.date('Y-m-d-Hms').' HRD System.sql','w+');
    fwrite($handle,$return);
    fclose($handle);
}

backup_tables($db);
    echo "<script>alert('การสำรองข้อมูลสำเสร็จแล้วจ้า!')</script>";
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    include_once 'footeri.php';
?>
