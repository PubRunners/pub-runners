
<!DOCTYPE>
<?PHP
session_name('runneradmin');	
session_start();
?>
<html>
<header>
	<?PHP
	include 'header.php';
	?>
<script>
$(document).ready( function () {
    $('#resulttable').dataTable( {
    "sScrollY": "200px",
    "bPaginate": true
    } );
} );
  </script>
</header>
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
						<?php
						if (isset($_SESSION["authenticated"]))
						{
						echo("
						<ul>
						<li><a href=\"logout?".SID."\"><span>logout</span></a></li>
						<li><a href=\"myrunner?trigger=0&".SID."\"><span>administration</span></a></li>
						<li><a href=\"contact?".SID."\"><span>Contact</span></a></li> 
						<li ><a href=\"runcalendar?".SID."\"><span>Events</span></a></li>
						<li><a href=\"news?".SID."\"><span>News</span></a></li>
						<li class=\"has-sub\"><a href=\"resulthistory?".SID."\"><span>Results</span></a></li>
						</ul>"
						);
						}
						else
						{
						echo("
						<ul> 
						<li><a href=\"login\"><span>administration</span></a></li>
						<li><a href=\"contact\"><span>Contact</span></a></li> 
						<li ><a href=\"runcalendar\"><span>Events</span></a></li>
						<li><a href=\"news\"><span>News</span></a></li>
						<li class=\"has-sub\"><a href=\"resulthistory\"><span>Results</span></a></li>
						</ul>");
						}
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
					<div class = "row">
						<div class="col-md-2">
						</br>
						<ul class="nav nav-list">
							<li class="nav-header">Results</li>
							<li><a href="resulthistory">result history</a></li>
							<li><a href="resultsearch">Simple Search</a></li>
							<li class="active"><a href="search">Advanced Search</a></li>
						</ul>
						</div>
						<div class="col-md-10"><!--main panel -->
						<div class="col-md-4"><!--left panel -->



<?PHP
echo ("<form action=\"advancedsearch.php\" method=\"POST\">");
echo("<div class=\"form-group\">");

echo("</br><legend>Advanced Search</legend>");
echo("<label>Search Type</label> &nbsp <select class=\"form-control\" name=\"searchtype\">");
	echo("<option value=\"RESULT\">Result</option>");
	echo("<option value=\"RUNNER\">Runner</option>");
	echo("<option value=\"TRACK\">Track</option>");
echo("<select name=\"searchtype\"></br>");
echo("<input type=\"hidden\" name=\"trigger\" value=1>");
echo("<div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Next</button>");
echo("</div>");
echo("</form>");
?>
</div>
<div class="col-md-6"><!--right blank panel -->
</div>
</div> <!--main panel -->
</div> <!--main row -->
</div> <!--container panel -->
</div> <!--container row -->
</div> <!--page main -->

</div> <!--row -->
</div> <!--container -->
				<?PHP
				include 'copyright.php';
				?>	
</body>
</html>