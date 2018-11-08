<?php
if (!isset($_SESSION))
    session_start();
require_once('./includes/functions.php');
header('Content-Type: text/html');
if ($_SESSION["login"] == "guest") {
    index_error(-1, "You must be logged in to view this page");
}
?>
<html>
    <head>
        <title>Image Upload</title>
        <?php require_once './includes/main-includes.php'; ?>
        <script src="./js/capture.js?1500" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="./css/capture.css"/>
    </head>
    <body>
        <?php
        require_once './includes/navbar.php';
        ?>

        <div class="container-fluid">

            <div class="row">
                <div class="col-xs-12">
                    <?php
                    require_once("./includes/Element.php");
                    $div = new Element("div", false);
                    $msg;
                    $class;
                    if (isset($_SESSION["errors"])) {
                        $msg = $_SESSION["errors"]["errmsg"];
                        $class = "alert alert-danger";
                    }
                    if (isset($_SESSION["success"])) {
                        $msg = $_SESSION["success"]["message"];
                        $class = "alert alert-success";
                    }
                    if (isset($_SESSION["errors"]) || isset($_SESSION["success"])) {
                        $div->add_class($class);
                        $div->add_text($msg);
                        echo $div;
                        unset($_SESSION["errors"]);
                        unset($_SESSION["success"]);
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="flex-column" id="col-right">
                    </div>
                    <canvas id="canvasVid" name="background" style="display:none;" width="500px" height="375px"></canvas>
                    <canvas id='canvasOver'name="overlay" style="display:none;" width="500px" height="375px"></canvas>
                </div>
                <div class="col-md-6 text-center">
                    <form action="<?php
                    echo "./upload.php?type=" . $_GET["type"];
                    ?>" method="post" enctype="multipart/form-data">
                        Select image to upload:
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload Image" name="submit">
                    </form>
                    <button class="btn btn-primary grey darken-4" onclick="" id="btn_snap">Snap</button>
                    <div class="contained">
                        <video autoplay="true" id="videoElement">
                        </video>
                        <div class="overlay">
                        </div>
                    </div>
                    <button class="btn btn-primary grey darken-4" onclick="uploadSnaps()" id="btn_upload">Upload Snaps</button>
                    <button class="btn btn-primary grey darken-4" onclick="clearSnaps()">Clear Snaps</button>
                </div>
                <div class="col-md-3">
                    <div class="flex-column">
                        <form class="form-overlays">
                            <div class="form-check flex-col-item">
                                <input type="checkbox" class="form-check-input" id="ov_c1" />
                                <label class="form-check-label" for="ov_c1"><img class="img-responsive" id="ov_1" src="./imgs/overlay.png" alt="" onclick=" "/></label>
                            </div>
                            <div class="form-check flex-col-item">
                                <input type="checkbox" class="form-check-input" id="ov_c2" />
                                <label class="form-check-label" for ="ov_c2"><img class="img-responsive" id="ov_2" src="./imgs/overlay2.png" alt="" onclick=""/></label>
                            </div>
                        </form>
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
                            //over = document.querySelectorAll(".icon");
                            var canvas = document.getElementById("canvasVid");
                            var can2 = document.querySelector("#canvasOver");
                            var button = document.getElementById("btn_snap");

                            button.disabled = false;
                            button.onclick = function (over) {
                                canvas.getContext("2d").drawImage(video, 0, 0, 500, 375);
								for (var x = 0; x < over.length; x++)
								{
									canvas.getContext("2d").drawImage(over[x], 0, 0, 500, 375);
									can2.getContext("2d").drawImage(over[x], 0, 0, 500, 375);
								}
                                var img = canvas.toDataURL("image/png");
                                        const imgnew = document.createElement("img");
                                        const colnew = document.createElement("div");
                                        imgnew.setAttribute('src', img);
                                colnew.setAttribute("class", "flex-col-item");
                                colnew.appendChild(imgnew);
                                        const btnclose = document.createElement("button");
                                        btnclose.setAttribute("class", "close");
                                btnclose.setAttribute("aria-label", "Close");
                                btnclose.setAttribute("type", "button");
                                btnclose.onclick = function (btnclose)
                                {
                                    objParent = btnclose.parentNode;
                                    row = objParent.parentNode;
                                    row.removeChild(objParent);
                                }.bind(null, btnclose);
                                ico = document.createElement("span");
                                ico.setAttribute("aria-hidden", "true");
                                ico.innerHTML = "&times;";
                                btnclose.appendChild(ico);
                                colnew.appendChild(btnclose);
                                var right = document.querySelector("#col-right");
                                right.insertBefore(colnew, right.childNodes[0]);

                            }.bind(null, document.querySelectorAll(".icon"));
                        })
                        .catch(function (err0r) {
                            console.log("Something went wrong!");
                        });
            }
        </script>
    </body>
</html>
