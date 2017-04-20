<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PaperCloud</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type = "text/javascript">


            var searchWord = "";

            function hash(n){
                var pos = n.charCodeAt(0) - 97;

                switch (pos){
                    case(pos<5):
                        return 30;
                    
                    case(pos<10):
                        return 50;

                    case(pos<15):
                        return 70;
                    
                    case(pos<20):
                        return 90;
                    
                    default:
                        return 100;

                }
            };
            
            function startBar() {
            var elem = document.getElementById("myBar"); 
            var width = 0;
            var max = 10;
           
            var fourth = hash(document.getElementById("myText").value);
            

            setTimeout(frame, 100);
            setTimeout(frame, 200);
            setTimeout(frame, 1000);
            setTimeout(frameFinal, 5000+fourth);

            function frame(){
                if (width<100){
                    var newNum = Math.floor(Math.random() * (max - width + 1)) + width;
                    console.log(newNum);
                    width+=newNum;
                    console.log("width is " + width);
                    max+=15;
                    elem.style.width = width + '%';
                }
                else {}
            }
            function frameFinal(){
                console.log(width);
                elem.style.width = 100 + '%';
            }
            };
            

            function goToCloudWithScholar(){
                startBar();


                var baseURL = "http://localhost:8000/papers/scholar/";
                searchWord = document.getElementById("myText").value;
                var url = baseURL.concat(searchWord);
                var e = document.getElementById("ddlViewBy");
                var numArticle = e.options[e.selectedIndex].value;
                url = url.concat("/");
                url = url.concat(numArticle);
                if (searchWord!=""){
                
                window.location.href = url;
                }
            };

            function goToCloudWithKeyword(){
                startBar();
                var baseURL = "http://localhost:8000/papers/keyword/";
                searchWord = document.getElementById("myText").value;
                var url = baseURL.concat(searchWord);
                var e = document.getElementById("ddlViewBy");
                var numArticle = e.options[e.selectedIndex].value;
                url = url.concat("/");
                url = url.concat(numArticle);

                if (searchWord != "") {
                    window.location.href = url;
                }
            };

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
    left: 22%;
    top: 40%;

}

#firstLine {
    float: left;
}
#firstLineB {
    float: right;

    
   
    min-width: 50px;
   
    padding: 20px 16px;
    
}

body {
    background-color: #126BBF;

}

form{
    display:inline-block;

}

input[type = "button"], input[type = "submit"], button {
    background-color:#D54A50;
    height: auto;
    width: 100%;
    font-size: 20px;
    color: white;
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
    font-size: 20px;
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

        <div id ="firstLine">
        
        <input type="text" name="searchWord" value = "" size ="50" id="myText">
        </div>

        <div id = "firstLineB">
        <select id="ddlViewBy">
        <option value="5">5</option>
        <option value="10" selected="selected">10</option>
        <option value="15">15</option>
         <option value="20">20</option>
        </select><font color = "white" face = "Arial">
        Top Articles
    </font>
        </div>
        


        <br><br>
        <button onclick="goToCloudWithScholar()" id = "scholarButton">Search by Scholar</button>
        <br><br>
        <button onclick="goToCloudWithKeyword()" id = "keywordButton">Search by Keyword</button>
        <br><br>
        
<div class="progress">
  <div class="progress-bar progress-bar-success progress-bar-striped" id = "myBar" role="progressbar"
  aria-valuemin="0" aria-valuemax="100" >
    Generating Your PaperCloud
  </div>
</div>
</div>
    </div>


</body>

