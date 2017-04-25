<!DOCTYPE html>


       
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
        <script type="text/javascript">    </script>
        <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
        <script type="text/javascript" src="{{ URL::asset('js/html2canvas.js') }}"></script>
        
        <script type="text/javascript" src="{{ URL::asset('js/jquery-latest.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/jquery.tablesorter.js') }}"></script> 
         <script type="text/javascript" src="{{ URL::asset('js/html2canvas.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

<script src="https://rawgit.com/someatoms/jsPDF-AutoTable/master/dist/jspdf.plugin.autotable.js"></script>

        <script>
    




       function createPDF() {

  var pdfsize = 'a0';
  var pdf = new jsPDF('l', 'pt', pdfsize);

  var res = pdf.autoTableHtmlToJson(document.getElementById("myTable"));
  pdf.autoTable(res.columns, res.data, {
    startY: 60,
    styles: {
      overflow: 'linebreak',
      fontSize: 12,
      rowHeight: 20,
      columnWidth: 'wrap'
    },
    columnStyles: {
      1: {columnWidth: 'auto'}
    }
  });

  pdf.save("table.pdf");
  };
  function findMaxLength(array){
    var length=0;
    for (var i=0; i <array.length; i++){
        if (length<array[i].length){
            length = array[i].length;
        }
    }
    return length;

  };
  function findMaxLengthAuthor(array){
    var length=0;
    
    for (var i=0; i <array.length; i++){
        var oneArticleLength=0;
        for (var x =0; x<array[i].length; x++){
            oneArticleLength+=array[i][x].length;
        }
        if (oneArticleLength>length){
            length = oneArticleLength;
        }
    }
    return length;
  }

  function createSubset(){
    var title = <?php echo sizeof($titles)?>;
    var string="";
    for (var i=0; i<title; i++){
        if (document.getElementById('box' + i).checked){
            string+="t";
        }
        else{
            string+="f";
        }
    }
    var baseURL = "http://localhost:8000/papers/subset/" + string;
    window.location.href = baseURL;

  };

  function createPlainText(filename, text){
    var title = <?php echo json_encode($titles)?>;
        var titleLength=findMaxLength(title);

    var author =<?php echo json_encode($authors)?>;
        var authorLength=findMaxLengthAuthor(author);

    var conference = <?php echo json_encode($conferences)?>;
        var conferenceLength=findMaxLength(conference);

    var frequency = <?php echo json_encode($frequencies) ?>;
       

    var sum = titleLength + authorLength + conferenceLength + 13;
    var text="-";
    for (var i=0; i<sum; i++){
        text+="-";
    }
    text+="\r\n";
    text+="|Title";
    for (var i=0; i<titleLength-5; i++){
        text+=" ";
    }
    text+="|Author";
    for (var i=0; i<authorLength-6; i++){
        text+=" ";
    }
    text+="|Conference";
    for (var i=0; i<conferenceLength-10; i++){
        text+=" ";
    }
    text+="|Frequency|";
  
    text+="\r\n";
    for (var i=0; i<sum; i++){
        text+="-";
    }
    
    for (var i =0; i <title.length; i++){
        text+=title[i];
        var addSpaceTitle = titleLength-title[i].length;
        for (var n =0; n<addSpaceTitle; n++){
            text+=" ";
        }
        text+="|";

        text+=author[i];
        
        var totAuthor=0;
        for (var n=0; n<author[i].length; n++){
            totAuthor+=author[i][n].length;
        }
        var addSpaceAuthor = authorLength-totAuthor;
        
        for (var n =0; n<addSpaceAuthor; n++){
            text+=" ";
        }
        
        
        text+="|";

        text+=conference[i];
        var addSpaceConference = conferenceLength-conference[i].length;
        for (var n =0; n<addSpaceConference; n++){
            text+=" ";
        }
        text+="|";

        text+=frequency[i];
        var addSpaceFrequency = 9-frequency[i].length;
        for (var n =0; n<addSpaceFrequency; n++){
            text+=" ";
        }
        text+="|" + "\r\n";

    }


    var pom = document.createElement('a');
    
    pom.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    pom.setAttribute('download', 'table');
        if (document.createEvent) {
        var event = document.createEvent('MouseEvents');
        event.initEvent('click', true, true);
        pom.dispatchEvent(event);
    }
    else {
        pom.click();
    }
    };

           

</script>

        <title> Papers List Page </title>
        <body> 
            
            
            <table id='myTable' class='tablesorter'>
                <thead> 
            <tr> 
            <th>Choose Subset</th>
            <th>Title</th> 
            <th>Author</th> 
            <th>Conference</th> 
            <th>Frequency</th> 
            <th>PDF</th> 
            <th>BibTex</th> 
            </tr> 
            </thead><tbody>
        <?php              
            
            for($i = 0; $i < sizeOf($titles); $i++) {
               if(sizeOf($titles) > 0) {
                    
                    echo "<tr>";
                    echo "<td>";
                    echo "<input type='checkbox' id='box".$i. "'>";
                    echo "</td>";
                    $title = $titles[$i];
                    
                    echo "<td><a href = '/abstract/$title/$word'>";
                    

                    echo $titles[$i];
                    echo "</a></td>";

                    echo "<td>";
                    for ($n = 0; $n < (sizeof($authors[$i])); $n++){
                    $baseURL = "http://localhost:8000/papers/scholar/";
                    $url = $baseURL.$authors[$i][$n]."/10";
                    echo "<a href = '".$url."'>";
                    echo $authors[$i][$n];
                    echo "</a>";
                    echo ", ";
                    }
                    echo "</td>";

                    $conference = $conferences[$i];
                    
                    echo "<td>";
                    echo "<a href = '/conference/$conference'>";
                    echo $conferences[$i];
                    echo "</td>";

                    echo "<td>";
                    echo $frequencies[$i];
                    echo "</td>";

                    echo "<td><a id = 'pdf";
                    echo $i;
                    echo "' href = '";
                    echo $downloadLinks[$i];
                    echo "'>";
                    echo "PDF";
                    echo "</a></td>";

                    $title = $titles[$i];
                    $pub = $pubs[$i];
                    echo "<td>";
                    echo "<a href = '/bibtex/$title/$pub'>";
                    echo "BibTex";
                    echo "</td>";
               }
            }
        

        ?>
        </tbody></table>

        </body>

<script type="text/javascript">
        $(document).ready(function() 
    { 
        $("#myTable").tablesorter( {sortList: [[4,1]]} ); 

                
                
    } 
); 
</script>
       

<style>
#wrapper {
    width: 100%;
    height: 100%;
    margin: 0 auto;
    text-align: center;

}
#search {
    position: fixed;
    left: 35%;
    top: 50%;

}

#searchCloud {
    position: fixed;
    left: 35%;
    top: 70%;

}

/* tables */
table.tablesorter {
    font-family:arial;
    background-color: #CDCDCD;
    margin:10px 0pt 15px;
    font-size: 8pt;
    width: 100%;
    text-align: left;
}
table.tablesorter thead tr th, table.tablesorter tfoot tr th {
    background-color: #e6EEEE;
    border: 1px solid #FFF;
    font-size: 8pt;
    padding: 4px;
}
table.tablesorter thead tr .header {
    background-image: url(bg.gif);
    background-repeat: no-repeat;
    background-position: center right;
    cursor: pointer;
}
table.tablesorter tbody td {
    color: #3D3D3D;
    padding: 4px;
    background-color: #FFF;
    vertical-align: top;
}
table.tablesorter tbody tr.odd td {
    background-color:#F0F0F6;
}
table.tablesorter thead tr .headerSortUp {
    background-image: url(asc.gif);
}
table.tablesorter thead tr .headerSortDown {
    background-image: url(desc.gif);
}
table.tablesorter thead tr .headerSortDown, table.tablesorter thead tr .headerSortUp {
background-color: #8dbdd8;
}



html, body {
    height: 100%;
}
html {
    display: table;
    margin: auto;
}

body {
    background-color: #126BBF;;
    vertical-align: text-top;
    display: table-cell;

}

form{
    display:inline-block;

}
#back {
    position: absolute;
    top: 0;
    left: 0;
}

input[type = "button"], input[type = "submit"], button {
    background-color: #D54A50;
    height: auto;
    width: 200px;
    color: white;
    font-size: 16px;
    display: inline-block;
    border-radius: 5px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border: 1px solid rgba(0,0,0,0.3);
    border-bottom-width: 3px;
}
input[type = "text"] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
pageTitle {
    font-size: 20px;
}
#buttons{
    text-align: center;
}
</style>
</head>
 <body>
    <div id = 'buttons'>
  <button onclick="createPDF()" id = "downloadButton0">Download PDF</button>
  <button onclick="createPlainText()" id = "downloadButton1">Download Plain Text</button>
  <button onclick="createSubset()" id = "downloadButton2">Create New Cloud</button>
      </div>
</body>






