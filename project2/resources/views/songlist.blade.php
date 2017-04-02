<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">




        <button id = "back" onclick = "goBack()"> Back to Word Cloud Page</button>

        <script type="text/javascript">
            function goBack() { 
                var artistId = <?php echo $artistId?>;
                var url = "http://localhost:8000/api/wordcloud/";
                url = url.concat(artistId);
                window.location.href = url;
            }
            

        </script>
        <title> Song List Page </title>

        <h1><b> <?php echo $word?> </b></h1>
        <body> 
        <?php      
            $songs = json_decode($songList, true);
            $tracks = json_decode($trackList, true);
            for($i = 0; $i < sizeOf($songs); $i++) {
               if($songs[$tracks[$i]['track']['track_name']] > 0) {
                    $track = $tracks[$i]['track']['track_name'];
                    echo "<a href = '/api/lyrics/$track/$artistId/$word'>$track</a>";
                    $frequency = $songs[$tracks[$i]['track']['track_name']];
                    echo " ($frequency)";
                    echo "<br>";
               }
            }
        ?>
        </body>


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
<!-- <body>
  <div id = "songList"> #Insert while loop for results
      <br>
      Song 1 (12)
      <br>
      Song 2 (10)
  </div>
</body> -->