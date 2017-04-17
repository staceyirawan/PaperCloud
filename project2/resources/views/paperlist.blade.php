<!DOCTYPE html>


       
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
        <script type="text/javascript">    </script>
        <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
        <script type="text/javascript" src="{{ URL::asset('js/jquery-latest.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/jquery.tablesorter.js') }}"></script> 
        

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
                    echo "<input type='checkbox' name='".$i. "'>";
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

                    echo "<td>";
                    echo "PDF";
                    echo "</td>";

                    echo "<td>";
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
        $("#myTable").tablesorter( {sortList: [[3,1]]} ); 
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
    background-color: #B345F1;
    height: auto;
    width: 120px;
    font-size: 12px;
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
</style>
</head>
 <body>
  
      
</body>






