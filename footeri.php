   <?php $db->close();?>


    </div><!-- /#wrapper -->
     
    <!-- Bootstrap core JavaScript -->
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
    <!--<script type="text/javascript" src="DatePicker/js/jquery-1.4.4.min.js"></script>
    <script src="option/js/bootstrap.js" type="text/javascript"></script>
    <!-- Page Specific Plugins
    <script src="js/raphael-min.js"></script>
    <script src="js/morris-0.4.3.min.js"></script>
    <script src="js/morris/chart-data-morris.js"></script>
    <script src="js/tablesorter/jquery.tablesorter.js"></script>
    <script src="js/tablesorter/tables.js"></script> 
    <script type="text/javascript" src="report_rm/jquery.js"></script>
    <script type="text/javascript" src="report_rm/jquery.js"></script>
    <script type="text/javascript" src="option/js/jquery.min.js"></script>-->
    <script src="report_rm/highcharts.js"></script>
    <script src="report_rm/exporting.js"></script>
    
    <script src="option/js/bootstrap.js"></script>
    <script src="option/DataTables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="option/DataTables/dataTables.bootstrap4.min.js" type="text/javascript"></script>
    <!--select2-->
    <script src="option/select2/select2.full.min.js" type="text/javascript"></script>
    <script>
      $(document).ready(function () {
        $("#dbtable1").DataTable();
        $('#dbtable2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
        $('#dbtable3').DataTable({
          "paging": false,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
        $(".select2").select2();
      });
    </script>
  </body>
</html>
