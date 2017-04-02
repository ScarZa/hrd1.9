var createTable = function (column, tid=null) {
    this.column = column;
    //this.data = data;
    this.tid = tid;
    //this.content = content;

    this.columnOBJ = JSON.parse(this.column);
    //this.dataOBJ = JSON.parse(this.data);
    
    this.GetHead = function () {
        var head = "<div class='table-responsive'><table id='" + this.tid + "' class='table table-border table-hover' frame='below'>" +
                "<thead bgcolor='#898888' style='text-align: center'><tr style='text-align: center'>" +
                "<th  style='text-align: center;vertical-align: middle;' width='5%' rowspan='2'>ลำดับ</th>";
        for (var key in this.columnOBJ) {
            colspan = this.columnOBJ[key].length;

            if (colspan == 0) {
                head += "<th style='text-align: center;vertical-align: middle;' rowspan='2'>" + key + "</th>";
            } else {
                head += "<th style='text-align: center' colspan='" + colspan + "'>" + key + "</th>";
            }
        }
        head += "</tr><tr>";
        for (var key in this.columnOBJ) {
            var value = this.columnOBJ[key];
            for (var keys in value) {

                head += "<th style='text-align: center'>" + value[keys] + "</th>";
            }
        }
        head += "</tr></thead>";
    return head;
    }

    this.GetTable = function (data,content) {
        var dataOBJ = JSON.parse(data);

        var table = this.GetHead();
        table += "<tbody>";
        var order = 1;
        
        $(function (){ 
        for (var i = 0; i < dataOBJ.length; i++) {
            table += "<tr class=''>";
            table += "<td align='center'>" + order + "</td>";
            //for (var dkey in ndataOBJ[i]) {
            $.each( dataOBJ[i], function( dkey, val ) {
                //if (ndataOBJ[i].hasOwnProperty(dkey))
                    table += "<td align='center'>" + val + "</td>";
            });
            table += "</tr>";
            order++;
        }
        table += "</tbody></table></div>";
        $('#' + content + '').html(table);
    });
    }

    this.GetTableAjax = function (locate, content) {
        this.locate = locate;

        var table = this.GetHead();
        table += "<tbody>";
        var order = 1;
        $.getJSON(this.locate, function (dataTB) {
            if (dataTB != null && dataTB.length > 0) {
                for (var i = 0; i < dataTB.length; i++) {
                    table += "<tr class=''>";
                    table += "<td align='center'>" + order + "</td>";
                    $.each( dataTB[i], function( dkey, val ) {
                    //for (var dkey in dataTB[i]) {
                       // if (dataTB[i].hasOwnProperty(dkey))
                            table += "<td align='center'>" + val + "</td>";
                    //}
                });
                    table += "</tr>";
                    order++;
                }
                table += "</tbody></table></div>";
                $('#' + content + '').html(table);
            }
        });

}


}
