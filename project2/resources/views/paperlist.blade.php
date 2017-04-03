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
                    echo $titles[$i];
                    echo "</td>";

                    echo "<td>";
                    for ($n = 0; $n < sizeof($authors); $n++){
                    echo $authors[$i][$n];
                    echo ", ";
                    }
                    echo "</td>";

                    echo "<td>";
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
        $("#myTable").tablesorter( {sortList: [[3,1], [1,0]]} ); 
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

#songList {
    position: fixed;
    left: 40%;

    text-align: left;
}

#lyrics {
    position: fixed;
    left: 20%;
    text-align: center;
    max-width: 700px;
}


html, body {
    height: 100%;
}
html {
    display: table;
    margin: auto;
}

body {
    background-color: #c5c8c4;
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






