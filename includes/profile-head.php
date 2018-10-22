<?php 
if(!isset($_SESSION))
    session_start();
header('Content-type: text/html');
?>
<div class="row">
    <div class="col-md-offset-1 col-md-3">
        <img class="avatar-lg img-responsive" src="./imgs/avatar.png" alt=""/>
    </div>
    <div class="col-md-6">
        <h1><?php echo $_SESSION["login"]?></h1>
        <br/>
        <!--<span>
            <i class="fa fa-cog" aria-hidden="true"></i> <h3 style="display: inline-block"><a class="nav-link nav-item" href="./profile_edit">Edit Profile</a></h3></span>-->
        <br/>
        <i class="fa fa-upload" aria-hidden="true"></i><h3 style="display:inline-block"><a class="nav-link" href="./capture?type=propic">Edit Profile Picture</a></h3>
    </div>
</div>
