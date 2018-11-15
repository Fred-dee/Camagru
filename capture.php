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

			<?php output_returns(); ?>
            <div class="row">
                <div class="col-sm-12 col-sm-offset-12 col-md-3">
                    <div class="flex-col" id="col-right">
                    </div>
                    <canvas id="canvasVid" name="background" style="display:none;" width="500px" height="375px"></canvas>
                    <canvas id='canvasOver'name="overlay" style="display:none;" width="500px" height="375px"></canvas>
                </div>
                <div class="col-sm-12 col-md-6 text-center">
                    <form class="form-inline" action="<?php
                    echo "./upload.php?type=" . $_GET["type"];
                    ?>" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label for="fileToUpload"><i class="fa fa-upload">Browse..</i></label>
                        	<input class="form-control" type="file" name="fileToUpload" id="fileToUpload" accept=".jpg, .jpeg, .png, .gif" style="visibility:hidden"/>
						</div>
                        <input class ="form-control btn btn-primary amber darken-3" type="submit" value="Upload Plain Image" name="submit" >
                        <input class="form-control btn btn-primary amber darken-4" type="button" value="Clear Selection" name="clear_input" />
                    </form>
                    <button class="btn btn-primary grey darken-4" onclick="" id="btn_snap">Snap</button>
                    <div class="contained">
                        <video autoplay="true" id="videoElement">
                        </video>
                        <div class="resizable" id="input_resize" style="display:none">
                            <img id="img_input" src="" alt ="" class ="icon" style="display:inherit">
                        </div>
                        <div class="overlay">
                        </div>
                    </div>
                    <button class="btn btn-primary grey darken-4" onclick="uploadSnaps()" id="btn_upload">Upload Snaps</button>
                    <button class="btn btn-primary grey darken-4" onclick="clearSnaps()">Clear Snaps</button>
                </div>
                <div class="col-sm-12 col-md-3 flex-col">
                    
                        <form class="form-overlays">
                            <div class="form-check-inline flex-col-item">
                                <input type="checkbox" class="form-check-input" id="ov_c1" />
                                <label class="form-check-label" for="ov_c1">
                                    <img class="img-responsive " id="ov_1" src="./imgs/overlay.png" alt="" onclick=""/>

                                </label>
                            </div>
                            <div class="form-check-inline flex-col-item">
                                <input type="checkbox" class="form-check-input" id="ov_c2" />
                                <label class="form-check-label" for ="ov_c2">
                                    <img class="img-responsive" id="ov_2" src="./imgs/overlay2.png" alt="" onclick=""/>
                                </label>
                            </div>
                            <div class="form-check-inline flex-col-item">
                                <input type="checkbox" class="form-check-input" id="ov_c3" />
                                <label class="form-check-label" for ="ov_c2">
                                    <img class="img-responsive" id="ov_3" src="./imgs/2-2-sunglasses-picture-thumb.png" alt="" onclick=""/>
                                </label>
                            </div>
                            <div class="form-check-inline flex-col-item">
                                <input type="checkbox" class="form-check-input" id="ov_c4" />
                                <label class="form-check-label" for ="ov_c2">
                                    <img class="img-responsive" id="ov_4" src="./imgs/lips.png" alt="" onclick=""/>
                                </label>
                            </div>
                        </form>
            
                </div>
            </div>

        </div>

        <br/>


        <?php
        require_once './includes/footer.php';
        ?>
    </body>
</html>
