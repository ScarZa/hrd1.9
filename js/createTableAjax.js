var createTableAjax = function () {
    
    this.GetNewTableAjax = function (content
                                    , jsonsource
                                    , tempdata
                                    , cols
                                    , namefunc = null
                                    , deltable = null
                                    , delfield = null
                                    , resend = null
                                    , edit = false
                                    , process = false
                                    , pnamefunc = null
                                    , detail = false
                                    , dmodal = null
                                    , print = false
                                    , printpage = null
                                    , red = null
                                    , orange = null
                                    , yellow = null
                                    , green = null
                                    , tid1 = null
                                    , tid2 = null
                                    , tid3 = null)
                                {
                var table = document.createElement ("table");
            	//table.border = "1px";
                if(tid1!=null){
                    var tid=tid1;
                }else if(tid2!=null){
                    var tid=tid2;
                }else if(tid3!=null){
                    var tid=tid3;
                }//console.log(tid1);console.log(tid);
                table.setAttribute("id", tid);
                table.setAttribute("class", "table table-striped table-bordered table-hover");
                //table.setAttribute("frame","below");
                var tHead = document.createElement ("thead");
                tHead.setAttribute("bgcolor","#898888");
                tHead.setAttribute("style","text-align: center");
                table.appendChild (tHead);
                var rowh = tHead.insertRow (-1);
                var cellh;
                for (var keys in cols) {
                    cellh = rowh.insertCell (-1);
                    cellh.innerHTML = cols[keys];
                }
            	var tBody = document.createElement ("tbody");
            	table.appendChild (tBody);
                tBody.setAttribute("style","text-align: center");
                var jsonsub=jsonsource.split("?");
                var form = new FormData();
                $.each( jsonsub, function( key, value ) {
                    if(key!=0){
                        form.append("data"+key, value);
                    }
                  });
                var settings = {
                    type: "POST",
                    url: jsonsub[0],
                    async: true,
                    crossDomain: true,
                    data:form,
                    contentType: false,
                    cache: false,
                    processData: false
                  }
                $.when($.ajax(settings)).then( function (dataTB, textStatus, xhr) { 
                var value=[];
                    if (dataTB != null && dataTB.length > 0) {
                for (var i = 0; i < dataTB.length; i++) {
                		var row = tBody.insertRow (-1);
                                var I=0;
                                    $.each( dataTB[i], function( dkey, val ) {
                    			var cell = row.insertCell (-1);
                    				cell.innerHTML = val;
                                                value[I]=val;
                                                I++;
                		});
//                                if(status==true){
//                                        var cellEdit = row.insertCell (-1);
//                                        if(status==0){
//                                        editButton = document.createElement("i");
//					cellEdit.appendChild(editButton);
//					editButton.setAttribute("class","fa fa-spinner fa-spin");
//                                        editButton.setAttribute("title","รอลงทะเบียนรับ");
//                                    }else if(status==1){
//                                    editButton = document.createElement("i");
//					cellEdit.appendChild(editButton);
//					editButton.setAttribute("class","fa fa-spinner");
//                                        editButton.setAttribute("title","กำลังดำเนินการ");
//                                    }else if(status==2){
//                                    editButton = document.createElement("img");
//					cellEdit.appendChild(editButton);
//					editButton.setAttribute("src","images/Symbol_-_Check.ico");
//                                        editButton.setAttribute("title","สำเร็จ");
//                                    }else if(status==3){
//                                    editButton = document.createElement("img");
//					cellEdit.appendChild(editButton);
//					editButton.setAttribute("src","images/button_cancel.ico");
//                                        editButton.setAttribute("title","ไม่สำเร็จ");
//                                    }
//                                        editButton.setAttribute("width","25");
//                                        
//                                }
                                if(print==true){
                                        var cellEdit = row.insertCell (-1);
					editButton = document.createElement("a");
					cellEdit.appendChild(editButton);
					editButton.innerHTML = "<img src='images/printer.ico' width='25'>";
					editButton.setAttribute("href","#");
                                        editButton.setAttribute("onclick","window.open('"+printpage+"?id="+value[0]+"', '', 'width=420,height=250');return false;");
                                }                                           
                                if(detail==true){
                                     var modalsub=dmodal.split("?");
                                        var cellEdit = row.insertCell (-1);
					editButton = document.createElement("a");
					cellEdit.appendChild(editButton);
					editButton.innerHTML = "<img id='modal-ico"+value[0]+"' src='images/icon_set1/file_search.ico' width='25'>";
					editButton.setAttribute("href","#");
                                        editButton.setAttribute("onclick",modalsub[0]+"("+modalsub[1]+")");
                                        editButton.setAttribute("data-toggle","modal");
                                        editButton.setAttribute("data-target","#"+modalsub[0]);
                                        editButton.setAttribute("data-whatever",value[0]);
                                }
                                if(process==true){
                                        var cellEdit = row.insertCell (-1);
					editButton = document.createElement("a");
					cellEdit.appendChild(editButton);
					editButton.innerHTML = "<img src='images/icon_set1/file_add.ico' width='25'>";
					editButton.setAttribute("href","#");
                                        editButton.setAttribute("onclick","loadAjax('#page-content','"+tempdata+"','"+value[0]+"','"+pnamefunc+"');");
                                }
                                if(edit==true){
                                        var cellEdit = row.insertCell (-1);
					editButton = document.createElement("a");
					cellEdit.appendChild(editButton);
					editButton.innerHTML = "<img src='images/icon_set1/file_edit.ico' width='25'>";
					editButton.setAttribute("href","#");
                                        editButton.setAttribute("onclick","loadAjax('#page-content','"+tempdata+"','"+value[0]+"','"+namefunc+"');");
                                        

					var cellDel = row.insertCell (-1);
					delButton = document.createElement("a");
					cellDel.appendChild(delButton);
					delButton.innerHTML = "<img src='images/icon_set1/file_delete.ico' width='25'>";
					delButton.setAttribute("href","#");
					delButton.setAttribute("onclick","DeleteData('../back/API/DeleteFileAPI.php','"+deltable+"','"+delfield+"','"+value[0]+"','"+resend+"','html');");
                                    }
            }
            	// var container = document.getElementById (content);
                // container.empty().appendChild(table);
                $('#' + content + '').empty().html(table);
            
            $("td:contains("+red+")").attr("style","background-color: #d61b1b;color: white");
            $("td:contains("+orange+")").attr("style","background-color: #e08002;color: white");
            $("td:contains("+yellow+")").attr("style","background-color: #e3fc07;");
                        $("td:contains(" + green + ")").attr("style", "background-color: #40ad57;color: white");
                        $("#"+tid1+"").DataTable();
            $("#"+tid2+"").DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
        $("#"+tid3+"").DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });
        // jQuery(function($) {
        //     //initiate dataTables plugin
        //     var myTable = 
        //     $('#'+tid)
        //     //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
        //     .DataTable( {
        //         bAutoWidth: false,
        //         "aoColumns": [
        //           { "bSortable": false },
        //           null, null,null, null, null,
        //           { "bSortable": false }
        //         ],
        //         "aaSorting": [],
                
                
        //         //"bProcessing": true,
        //         //"bServerSide": true,
        //         //"sAjaxSource": "http://127.0.0.1/table.php"	,
        
        //         //,
        //         //"sScrollY": "200px",
        //         //"bPaginate": false,
        
        //         //"sScrollX": "100%",
        //         //"sScrollXInner": "120%",
        //         //"bScrollCollapse": true,
        //         //Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
        //         //you may want to wrap the table inside a "div.dataTables_borderWrap" element
        
        //         //"iDisplayLength": 50
        
        
        //         select: {
        //             style: 'multi'
        //         }
        //     } );
        
            
            
        //     $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
            
        //     new $.fn.dataTable.Buttons( myTable, {
        //         buttons: [
        //           {
        //             "extend": "colvis",
        //             "text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
        //             "className": "btn btn-white btn-primary btn-bold",
        //             columns: ':not(:first):not(:last)'
        //           },
        //           {
        //             "extend": "copy",
        //             "text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
        //             "className": "btn btn-white btn-primary btn-bold"
        //           },
        //           {
        //             "extend": "csv",
        //             "text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
        //             "className": "btn btn-white btn-primary btn-bold"
        //           },
        //           {
        //             "extend": "excel",
        //             "text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
        //             "className": "btn btn-white btn-primary btn-bold"
        //           },
        //           {
        //             "extend": "pdf",
        //             "text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
        //             "className": "btn btn-white btn-primary btn-bold"
        //           },
        //           {
        //             "extend": "print",
        //             "text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
        //             "className": "btn btn-white btn-primary btn-bold",
        //             autoPrint: false,
        //             message: 'This print was produced using the Print button for DataTables'
        //           }		  
        //         ]
        //     } );
        //     myTable.buttons().container().appendTo( $('.tableTools-container') );
            
        //     //style the message box
        //     var defaultCopyAction = myTable.button(1).action();
        //     myTable.button(1).action(function (e, dt, button, config) {
        //         defaultCopyAction(e, dt, button, config);
        //         $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
        //     });
            
            
        //     var defaultColvisAction = myTable.button(0).action();
        //     myTable.button(0).action(function (e, dt, button, config) {
                
        //         defaultColvisAction(e, dt, button, config);
                
                
        //         if($('.dt-button-collection > .dropdown-menu').length == 0) {
        //             $('.dt-button-collection')
        //             .wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
        //             .find('a').attr('href', '#').wrap("<li />")
        //         }
        //         $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
        //     });
        
        //     ////
        
        //     setTimeout(function() {
        //         $($('.tableTools-container')).find('a.dt-button').each(function() {
        //             var div = $(this).find(' > div').first();
        //             if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
        //             else $(this).tooltip({container: 'body', title: $(this).text()});
        //         });
        //     }, 500);
            
        //     myTable.on( 'select', function ( e, dt, type, index ) {
        //         if ( type === 'row' ) {
        //             $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
        //         }
        //     } );
        //     myTable.on( 'deselect', function ( e, dt, type, index ) {
        //         if ( type === 'row' ) {
        //             $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
        //         }
        //     } );
        
        // })
    }else{
        $('#' + content + '').text("ไม่มีข้อมูลแสดงครับ ^_^ ");
    }
    });
    }    

            
        }
