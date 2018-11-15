<?php
if(!isset($_SESSION))
    session_start();
?>
<!-- Footer -->
<footer class="page-footer font-small bg-transparent  fixed-bottom">

  <!-- Copyright -->
  <?php
  
  if (basename($_SERVER['PHP_SELF']) == "index.php")
  {
  ?>    
  <div class="row bg-transparent text-dark" >
      <div class="col-xs-2 text-center col-xs-offset-5">
          <a href="./capture.php?type=gallery" class="btn btn-primary grey darken-3 "><i class="fas fa-camera"></i></a>
      </div>
    </div>
  <?php
  }
  ?>
  <div class="footer-copyright grey darken-4 text-center py-3">© 2018 Copyright:
    <a href="https://github.com/Fred-Dee/">Fred Dilapisho, mdilapi</a>
    
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->