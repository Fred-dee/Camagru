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
            .container {
                position: relative;
                margin: 0px auto;
                width: 500px;
                height: 375px;
                border: 10px #333 solid;
            }
            
            .container:hover .overlay
            {
                opacity: 1;
            }
            .overlay {
              position: absolute;
              top: 0;
              bottom: 0;
              left: 0;
              right: 0;
              height: 100%;
              width: 100%;
              opacity: 0;
              transition: .3s ease;
              
            }
            #videoElement {
                width: 500px;
                height: 375px;
                background-color: #666;
            }
            .icon {
              color: white;
              font-size: 100px;
              position: absolute;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -50%);
              -ms-transform: translate(-50%, -50%);
              text-align: center;
            }
        </style>
    </head>
    <body>
        <?php
        require_once './includes/navbar.php';
        ?>
        <div class="container">
            <video autoplay="true" id="videoElement">
            </video>
            <div class="overlay">
                <img id="img_overlay" src="./imgs/overlay2.png" alt="" class="img-responsive icon"/>
            </div>
        </div>
        <button class="btn btn-primary grey darken-4" onclick="" id="btn_snap">Snap</button>
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
                            var over;
                            over = document.getElementById("img_overlay");
                        var canvas = document.getElementById("c");
                        var button = document.getElementById("btn_snap");

                        button.disabled = false;
                        button.onclick = function() {
                            canvas.getContext("2d").drawImage(video, 0, 0, 500, 375, 0, 0, 500, 375);
                            canvas.getContext("2d").drawImage(over, 0, 0, 500, 375, 0, 0, 500, 375);
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
