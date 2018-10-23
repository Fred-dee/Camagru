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
        <link rel="stylesheet" type="text/css" href="./css/capture.css"/>
        <style>
            .container {
                position: relative;
                width: 500px;
                height: 375px;
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
              text-align: center;
            }
            #videoElement {
                width: 500px;
                height: 375px;
                background-color: #666;
                transform: rotateY(180deg);
                -webkit-transform:rotateY(180deg); /* Safari and Chrome */
                -moz-transform:rotateY(180deg); /* Firefox */
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12"><button class="btn btn-primary grey darken-4" onclick="" id="btn_snap">Snap</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3" id="col-right">
                    <canvas id="c" style="display:box;" width="500px" height="375px"></canvas>
                </div>
                <div class="col-md-6">
                    <div class="container">
                        <video autoplay="true" id="videoElement">
                        </video>
                        <div class="overlay">
                            <img id="img_overlay" src="./imgs/overlay.png" alt="" class="img-responsive icon" style="width: inherit; height: inherit"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="flex-column">
                        <div class="flex-col-item">
                            <img class="img-responsive" id="ov_1" src="./imgs/overlay.png" alt="" />
                        </div>
                        <div class="flex-col-item">
                            <img class="img-responsive" id="ov_2" src="./imgs/overlay2.png" alt="" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
        <br/>

        
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
                            const imgnew = document.createElement("img");
                            imgnew.setAttribute('src', img);
                            var right =  document.querySelector("#col-right");
                            right.insertBefore(imgnew, right.childNodes[0]);
                            
                        };
                        })
                        .catch(function (err0r) {
                            console.log("Something went wrong!");
                        });
            }
        </script>
    </body>
</html>
