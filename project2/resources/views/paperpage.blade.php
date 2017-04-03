<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="/js/mark.min.js"></script>

        <title>PaperPage</title>
        

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
    float:left;
    text-align: left;
}



body {
    background-color: #c5c8c4;
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

<div id = "wrapper">
    <pageTitle></pageTitle>
    <br><br>
    <div class = "context">
        
    </div>
    </body>
</div>
