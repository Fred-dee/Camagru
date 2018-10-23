<?php
if (!isset($_SESSION))
    session_start();
require_once('./includes/functions.php');
if ($_SESSION["login"] == "guest") {
    index_error(-1, "You must be logged in to view this page");
}
header('Content-Type: text/html');
?>
<html>
    <head>
        <title>Image Upload</title>
        <?php require_once './includes/main-includes.php'; ?>
        <script src="./js/capture.js" type="text/javascript"></script>
        <style>
            #container {
                margin: 0px auto;
                width: 500px;
                height: 375px;
                border: 10px #333 solid;
            }
            #videoElement {
                width: 500px;
                height: 375px;
                background-color: #666;
            }
        </style>
    </head>
    <body>
        <?php
        require_once './includes/navbar.php';
        ?>
        <div id="container">
            <video autoplay="true" id="videoElement">
            </video>
        </div>
        <button class="btn btn-primary grey darken-4" onclick="getMedia()" id="btn_snap">Snap</button>
        <br/>

        <canvas id="c" style="display:box;" width="500px" height="375px"></canvas>
        <?php
            require_once './includes/footer.php';
        ?>
        <script>
            var video = document.querySelector("#videoElement");

            if (navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({video: true})
                        .then(function (stream) {
                            video.srcObject = stream;
                    
                        var canvas = document.getElementById("c");
                        var button = document.getElementById("btn_snap");
                        //video.src = stream;
                        button.disabled = false;
                        button.onclick = function() {
                            canvas.getContext("2d").drawImage(video, 0, 0, 500, 375, 0, 0, 500, 375);
                            var img = canvas.toDataURL("image/png");
                        };
                        })
                        .catch(function (err0r) {
                            console.log("Something went wrong!");
                        });
            }
        </script>
    </body>
</html>
