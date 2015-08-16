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
<script type="text/javascript" charset="utf-8" src="/DataTables/media/js/jquery.dataTables.js"></script>
<style type="text/css" title="currentStyle">
    @import "/DataTables/media/css/demo_table.css";
</style>	
<script>
$(document).ready( function () {
    $('#resulttable').dataTable( {
    "sScrollY": "425px",
    "bPaginate": true
    } );
} );
  </script>
</head>
<body>
	<div class="container-fluid">
		<div class ="row">
			<div class ="col-md-1">
			</div>
			<div class ="col-md-10" id="pagemain">
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
	 echo("</br>");
	 echo("<legend>Simple Search </legend>");
 //database connection
 include 'connection.php'; 
  // data functions
 include 'functions.php'; 


echo("<table id=\"resulttable\" class=\"table table-hover table-bordered\">");
echo("<thead>");
echo("<tr><th>Date</th><th>Track</th><th>Runner</th><th>Result</th><th>Note</th></tr>");
echo("</thead>");
echo("<tbody>");
$sql = "SELECT vr.date,vr.track,vr.runner,vr.time,(CASE WHEN (vr.time = (SELECT min(a.time) FROM vw_results a WHERE a.track_id = vr.track_id AND a.runner_id = vr.runner_id)) THEN 'YES' END)  as pb from vw_results vr";
//$sql = "SELECT date,track,runner,time,personalbestcheck(result_id) as pb from vw_results";
$result = mysqli_query($conn, $sql) or die("Error getting track list");
while ($row = mysqli_fetch_array($result)) 
	{
		$pbstatus = $row["pb"];
		$pb = " ";
		if ($pbstatus == 'YES')
		{
		$pb = "New PB!";
		}
		
	echo("<tr><td>".$row["date"]."</td><td>".$row["track"]."</td><td>".$row["runner"]."</td><td>".$row["time"]."</td><td><strong>".$pb."</strong></td></tr>");
	}
echo("</tbody>");
echo("</table>");

?>
</div> <!--main panel -->
</div> <!--main row -->
</div> <!--container panel -->
</div> <!--container row -->
</div> <!--page main -->

</div> <!--row -->

</div> <!--container -->
</br>
</br>
</body>
				<?PHP
				include 'copyright.php';
				?>	

</html>