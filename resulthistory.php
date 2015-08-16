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
			<div class ="col-md-10" id="pagemain" style="height: 100%;">
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
						<div class="col-md-10"> <!--main panel -->
<?php

 //database connection
 include 'connection.php'; 
  // data functions
 include 'functions.php'; 

echo("<br><legend>Result History</legend>");
echo("<table id=\"resulttable\" class=\"table table-hover table-bordered\">");
echo("<thead>");
echo("<tr><th>Track</th><th>Date</th><th>Participants</th><th>Fastest</th><th>average</th><th>View</th></tr>");
echo("</thead>");
echo("<tbody>");
$sql = "select result_set_id, track,date,participants,fastest_time, average_time from vw_result_set where participants > 0";
$result = mysqli_query($conn, $sql) or die("Error getting track list");
while ($row = mysqli_fetch_array($result)) 
	{	
	echo("<tr><td>".$row["track"]."</td><td>".$row["date"]."</td><td>".$row["participants"]."</td><td>".$row["fastest_time"]."</td><td>".$row["average_time"]."</td><td><a href=\"runresults.php?setid=".$row["result_set_id"]."\">results</a></td></tr>");
	}
echo("</tbody>");
echo("</table>");

?>
</div> <!--main panel -->
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