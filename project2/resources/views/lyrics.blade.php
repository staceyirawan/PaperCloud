<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="/js/mark.min.js"></script>

        <title>Chosen Song title and Artist Here</title>
        <script type = "text/javascript">
			function backToWordCloud(){
				var artistId = <?php echo $artistId ?>;
				var baseURL = "http://localhost:8000/api/wordcloud/";
				var url = baseURL.concat(artistId);

				window.location.href = url
			}

			function backToSongList(){
				var artistId = <?php echo $artistId ?>;
				var word = "<?php echo $word ?>";
				var baseURL = "http://localhost:8000/api/songlist/";
				var url = baseURL.concat(word);
				url = url.concat("/");
				url = url.concat(artistId);
				window.location.href = url
			}

			function loadLyrics(){
				var lyricsString = "<?php echo $lyrics ?>";
				document.getElementById("lyrics").innerHTML = lyricsString;
				var songTitle = "<?php echo $songTitle ?>";
				var artistName = "<?php echo $artistName ?>";
				var title = songTitle.concat(" by ").concat(artistName);
				document.getElementsByTagName("pageTitle")[0].innerHTML = title;
				document.title = title;

                var instance = new Mark(document.querySelector("div.context"));
                var word = "<?php echo $word ?>";
                instance.mark(word, {
                    accuracy: "exactly",
                    limiters: ["(", ")"] 
                });
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
    left: 35%;
    top: 70%;

}

#songList {
    position: fixed;
    left: 40%;
    float:left;
    text-align: left;
}

#lyrics {
    position: fixed;
    left: 35%;
    text-align: center;
    max-width: 700px;
    overflow-y: auto;
    height: 500px;
}

body {
    background-color: #c5c8c4;
	overflow-y: scroll;
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
<button style = "button" onclick = "backToWordCloud()">Back to Word Cloud</button>
<button style = "button" onclick = "backToSongList()">Back to Song List</button>
<div id = "wrapper">
    <pageTitle></pageTitle>
    <br><br>
    <div class = "context">
        <div id = "lyrics"> 
            <body onload = "loadLyrics()">
        </div>
    </div>
    </body>
</div>
