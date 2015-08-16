<!DOCTYPE>
<?PHP
session_name('runneradmin');	
session_start();
?>
<html>
<head>
	<?PHP
	include 'header.php';
	?>	
</head>
<body>
<div class="container-fluid">
		<div class ="row">
			<div class ="col-md-1">
			</div>
			<div class ="col-md-10" id="pagemain" style="height:100%;">
				<?PHP
				include 'title.php';
				?>	
				<div class="row">
					<div class="col-md-12" id="cssmenu">
										<ul> 
						<li><a href='login'><span>administration</span></a></li>
						<li><a href='contact'><span>Contact</span></a></li> 
						<li ><a href='runcalendar'><span>Events</span></a></li>
						<li><a href='news'><span>News</span></a></li>
						<li class='has-sub'><a href='resulthistory'><span>Results</span></a></li>
					</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
					<div class = "row">
						<div class="col-md-4">
						</div>
						<div class="col-md-4"> <!--main panel -->

<?php
      echo("<form class=\"form-signin\" role=\"form\" method=\"POST\" action=\"welcome\">");
    echo("<h2 class=\"form-signin-heading\">Please sign in</h2>");
       echo("<input type=\"text\" class=\"form-control\" placeholder=\"Username\" name=\"userid\" required autofocus><br>");
        echo("<input type=\"password\" class=\"form-control\" placeholder=\"Password\" name =\"password\" required>");
		echo("<!--<input type=\"hidden\" name=\"trigger\" value=0>-->");
        echo("<button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\">Sign in</button>");
      echo("</form>");
?>	  
</div> <!--main panel -->
						<div class="col-md-4">
						</div>
</div> <!--main row -->
</div> <!--container panel -->
</div> <!--container row -->
</div> <!--page main -->
				<?PHP
				include 'copyright.php';
				?>	
</div> <!--row -->
</div> <!--container -->
</body>
</html>