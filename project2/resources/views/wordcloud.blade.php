<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PaperCloud</title>
        <br>
        <script type="text/javascript" src="{{ URL::asset('js/html2canvas.js') }}"></script>

        <script type = "text/javascript">
        
            //download word cloud             
            function downloadCloud(){
                html2canvas(document.body, {
                    onrendered: function(canvas) {
                        var saveData = (function () {
                            var a = document.createElement("a");
                            document.body.appendChild(a);
                            a.style = "display: none";
                            return function (data, fileName) {
                                var url = window.URL.createObjectURL(blob);
                                a.href = url;
                                a.download = fileName;
                                a.click();
                                window.URL.revokeObjectURL(url);
                            };
                        }());
                        var blob = dataURItoBlob(canvas.toDataURL());
                        saveData(blob, "wordcloud.png");
                    },
					background: '#126bbf',
                });
            };

            function dataURItoBlob(dataURI) {
                var byteString = atob(dataURI.split(',')[1]);
                var ab = new ArrayBuffer(byteString.length);
                var ia = new Uint8Array(ab);
                for (var i = 0; i < byteString.length; i++) {
                    ia[i] = byteString.charCodeAt(i);
                }
                return new Blob([ab], {type: 'image/png'});
            }

            
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
    left: 5%;
    top: 10%;

}

#screenshot {
    left: 50%;
    top: 90%;
    text-align: center;
}

a{
  text-decoration: none;
color: #f8f8f8; font-family: 'Raleway',sans-serif;
}


body {
    background-color: #126BBF;

}

form{
    display:inline-block;

}

input[type = "button"], input[type = "submit"], button {
    background-color: #D54A50;
    height: auto;
    width: 300px;
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
</style>
</head>



 <body>
    
    
    <div id = "searchCloud">
<?php
    echo $wordCloudString;
    ?>
        
        <div id = "screenshot">
        <br><br>
        <button onclick="downloadCloud()" id = "downloadButton">Download</button>
        </div>


</div>
</body>
