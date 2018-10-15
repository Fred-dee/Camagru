<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
}
header('Content-type: text/html');
?>
<nav class="navbar navbar-expand-lg navbar-dark indigo fixed-top scrolling-navbar">
  <!-- Navbar brand -->
  <a class="navbar-brand" href="#">Camagru</a>

  <!-- Collapse button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
    aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Collapsible content -->
  <div class="collapse navbar-collapse" id="basicExampleNav">

    <!-- Links -->
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home
          <span class="sr-only">(current)</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>

      <!-- Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">Dropdown</a>
        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>

    </ul>
    <!-- Links -->
  	<!-- avatar or signin/login -->
	  <?php
	  	/*
			TODO:
				find the avatar from the users database
	  	*/
	  	if (isset($_SESSION["login"]))
		{
			if ($_SESSION["login"] == "guest")
			{
				echo "<a class='nav-lin' href='./login'>Login/Sign-up</a>";
			}
			else
			{
				echo "<img src='./imgs/avatar.png' alt='Avatar' class='avatar' />";
			}
		}
	  ?>
  	<!-- /Avatar or signin/login -->
  </div>
  <!-- Collapsible content -->
</nav>
