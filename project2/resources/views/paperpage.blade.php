<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PaperPage</title>
        

<style>
#wrapper {
    width: 100%;
    height: 100%;
    margin: 0 auto;
    text-align: left;

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

span.highlight {
    background-color: yellow;
}

#wrap{
    width: screen.width; 
    word-wrap: break-word;
}


h1 { color: #ffffff; font-family: 'Raleway',sans-serif; font-size: 62px; font-weight: 500; line-height: 50px; margin: 0 0 24px; text-align: center; text-transform: uppercase; }


h2 { color: #ffffff; font-family: 'Raleway',sans-serif; font-size: 30px; font-weight: 800; line-height: 36px; margin: 0 0 24px; text-align: left; }

h3 { color: #000000; font-family: 'Raleway',sans-serif; font-size: 25px; font-weight: 800; line-height: 20px; margin: 0 0 24px; text-align: left; }


p { color: #f8f8f8; font-family: 'Raleway',sans-serif; font-size: 18px; font-weight: 500; line-height: 32px; margin: 0 0 24px; }


a { color: #c8c8c8; text-decoration: underline; }



body {
    background-color: #126BBF;
	overflow-y: scroll;
}

form{
    display:inline-block;
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

</style>    
</head>
<body>
<div id = "wrapper">
    
    <br><br>
    <div class = "context">
        <?php 
            echo "<h2><a>";
            echo $title;
            echo "</a></h2><h3>";
            echo "Abstract:";
            echo "</h3>";
            
            $words = explode(' ', $abstract);
            $abstract = '';
            foreach($words as $str){
                if (strtolower($str) == $word) {
                    $abstract = $abstract . "<span class='highlight'>$str</span>" . " ";
                }
                else
                {
                    $abstract = $abstract . $str . " ";
                }
            }
            echo '<div id="wrap">'.$abstract.' </div>';
        ?>
    </div>
</body>
</div>
