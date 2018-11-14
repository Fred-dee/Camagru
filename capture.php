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
                <div class="col-sm-12 col-sm-offset-12 col-md-3">
                    <div class="flex-column" id="col-right">
                    </div>
                    <canvas id="canvasVid" name="background" style="display:none;" width="500px" height="375px"></canvas>
                    <canvas id='canvasOver'name="overlay" style="display:none;" width="500px" height="375px"></canvas>
                </div>
                <div class="col-sm-12 col-md-6 text-center">
                    <form action="<?php
                    echo "./upload.php?type=" . $_GET["type"];
                    ?>" method="post" enctype="multipart/form-data">
                        Select image to upload:
                        <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg, .jpeg, .png, .gif" />
                        <input type="submit" value="Upload Image" name="submit" >
                        <input type="button" value="clear" name="clear_input" class="btn btn-primary amber darken-4"/>
                    </form>
                    <button class="btn btn-primary grey darken-4" onclick="" id="btn_snap">Snap</button>
                    <div class="contained">
                        <video autoplay="true" id="videoElement">
                        </video>
                        <div class="resizable" id="input_resize" style="display:none">
                            <img id="img_input" src="" alt ="" class ="icon" style="display:inherit">
                            <span class='resize-topright'></span>
                            <span class='resize-topleft'></span>
                            <span class='resize-bottomleft'></span>
                            <span class='resize-bottomright'></span>
                            <span class='resize-middleright'></span>
                            <span class='resize-middleleft'></span>
                        </div>
                        <div class="overlay">
                        </div>
                    </div>
                    <button class="btn btn-primary grey darken-4" onclick="uploadSnaps()" id="btn_upload">Upload Snaps</button>
                    <button class="btn btn-primary grey darken-4" onclick="clearSnaps()">Clear Snaps</button>
                </div>
                <div class="col-sm-12 col-md-3 flex-column">
                    <div class="">
                        <form class="form-overlays">
                            <div class="form-check flex-col-item">
                                <input type="checkbox" class="form-check-input" id="ov_c1" />
                                <label class="form-check-label" for="ov_c1">
                                    <img class="img-responsive " id="ov_1" src="./imgs/overlay.png" alt="" onclick=""/>

                                </label>
                            </div>
                            <div class="form-check flex-col-item">
                                <input type="checkbox" class="form-check-input" id="ov_c2" />
                                <label class="form-check-label" for ="ov_c2">
                                    <img class="img-responsive" id="ov_2" src="./imgs/overlay2.png" alt="" onclick=""/>
                                </label>
                            </div>
                            <div class="form-check flex-col-item">
                                <input type="checkbox" class="form-check-input" id="ov_c3" />
                                <label class="form-check-label" for ="ov_c2">
                                    <img class="img-responsive" id="ov_3" src="./imgs/2-2-sunglasses-picture-thumb.png" alt="" onclick=""/>
                                </label>
                            </div>
                            <div class="form-check flex-col-item">
                                <input type="checkbox" class="form-check-input" id="ov_c4" />
                                <label class="form-check-label" for ="ov_c2">
                                    <img class="img-responsive" id="ov_4" src="./imgs/lips.png" alt="" onclick=""/>
                                </label>
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
    </body>
</html>
