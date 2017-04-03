<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PaperCloud</title>

        <script type = "text/javascript">

            var searchWord = "";

            function goToCloudWithScholar(){
                var baseURL = "http://localhost:8000/papers/scholar/";
                searchWord = document.getElementById("myText").value;
                var url = baseURL.concat(searchWord);
                if (artistID!=""){
                window.location.href = "http://localhost:8000/papers/asdf"
                //window.location.href = url;} FIX THIS!!!!!!!
                }
            function goToCloudWithKeyword(){
                var baseURL = "http://localhost:8000/papers/keyword/";
                searchWord = document.getElementById("myText").value;
                var url = baseURL.concat(searchWord);
                if (searchWord != "") {
                    window.location.href = url;
                }
            }


        </script>
<!-- Style -->
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

body {
    background-color: #c5c8c4;

}

form{
    display:inline-block;

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
<body onload = "getTextString()">
    <div id = "search">
        <br>
        <input type="text" name="searchWord" value = "" size ="50" id="myText">
        <br><br>
        <button onclick="goToCloudWithScholar()">Search by Scholar</button>
        <button onclick="goToCloudWithKeyword()">Search by Keyword</button>
        <br>

</div>
    </div>


</body>

