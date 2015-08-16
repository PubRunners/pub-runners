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
	<script type="text/javascript" charset="utf-8" src="/DataTables/media/js/jquery.dataTables.js"></script>
<style type="text/css" title="currentStyle">
    @import "/DataTables/media/css/demo_table.css";
</style>
<script>
$(document).ready( function () {
    $('#resulttable').dataTable( {
    "sScrollY": "400px",
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
						<div class="col-md-10"></br> <!--main panel -->
<!--

-->
<?php

 //database connection
 include 'connection.php'; 
  // data functions
 include 'functions.php'; 

$trigger = $_POST['trigger'];


if ($trigger == 1)
{
echo("<div class=\"col-md-4\">");
$searchtype = $_POST["searchtype"];
		if ((!isSet($_POST["searchtype"])))
		die("you must select a search type <a href=\"advancedsearch.php?trigger=0\">Back</a>");
if ($searchtype == "RESULT")
{

$sql = "SELECT result_set_id,Result FROM (select rs.result_set_id,CONCAT(CONCAT(DATE_FORMAT(rs.result_date,'%d/%m/%Y'),' - '),t.track_name) Result
										  from result_set rs 
										  join track t
										  ON (t.track_id = rs.track_id)
										  Where rs.result_set_id IN (select result_set_id from result)) result_table";
							
$result = mysqli_query($conn,$sql) or die("error fetching row from runnerDb - ".mysql_error($conn));

if (mysqli_num_rows($result) == 0)
				die("Error – no results found");
echo ("<form action=\"advancedsearch.php\" method=\"POST\">");
echo("<div class=\"form-group\">");

echo("<legend>Advanced Search</legend>");
echo("<label>Select a Result</label> &nbsp <select  class=\"form-control\" name=\"type_id\">");
echo("<option> </option>");
while ($row = mysqli_fetch_array($result))

			{
				echo("<option value=".$row["result_set_id"].">".$row["Result"]."</option>");
			}
echo("</select></br>");
echo("<input type=\"hidden\"  name=\"trigger\" value=2>");
echo("<input type=\"hidden\" name=\"searchtype\" value='$searchtype'>");
echo("<div class=\"pull-right\">");
echo("<a href=\"#\" onclick=\"history.go(-1)\"><input type=\"button\"class=\"btn btn-primary\" value=\"Back\"></a> &nbsp");
echo("<button type=\"submit\" class=\"btn btn-primary\">Next</button>");
echo("</div>");
echo("</div>");
echo("</form>");
}

if ($searchtype == "RUNNER")
{

$sql = "SELECT runner_id, runner
		FROM(select runner_id, CONCAT(CONCAT(first_name,' '),surname) runner
			 from runner
			 where runner_id IN (select runner_id from result)) runner_table";
							
$result = mysqli_query($conn,$sql) or die("error fetching row from runnerDb - ".mysql_error($conn));

if (mysqli_num_rows($result) == 0)
				die("Error – no results found");
echo ("<form action=\"advancedsearch.php\" method=\"POST\">");
echo("<div class=\"form-group\">");

echo("<legend>Advanced Search</legend>");
echo("<label>Select a Runner</label> &nbsp <select  class=\"form-control\" name=\"type_id\">");
echo("<option> </option>");
while ($row = mysqli_fetch_array($result))

			{
				echo("<option value=".$row["runner_id"].">".$row["runner"]."</option>");
			}
echo("</select></br>");
echo("<input type=\"hidden\" name=\"searchtype\" value='$searchtype'>");
echo("<input type=\"hidden\" name=\"trigger\" value=2>");
echo("<div class=\"pull-right\">");
echo("<a href=\"#\" onclick=\"history.go(-1)\"><input type=\"button\"class=\"btn btn-primary\" value=\"Back\"></a> &nbsp");
echo("<button type=\"submit\" class=\"btn btn-primary\">Next</button>");
echo("</div>");
echo("</div>");
echo("</form>");
}
if ($searchtype == "TRACK")
{
$sql = "SELECT track_id, track_name
		FROM track
		where track_id IN (select track_id from result)";
							
$result = mysqli_query($conn,$sql) or die("error fetching row from runnerDb - ".mysql_error($conn));

if (mysqli_num_rows($result) == 0)
				die("Error – no results found");
echo ("<form action=\"advancedsearch.php\" method=\"POST\">");
echo("<div class=\"form-group\">");

echo("<legend>Advanced Search</legend>");
echo("<label>Select a Track</label> &nbsp <select  class=\"form-control\" name=\"type_id\">");

while ($row = mysqli_fetch_array($result))

			{
				echo("<option value=".$row["track_id"].">".$row["track_name"]."</option>");
			}
echo("</select></br>");
echo("<input type=\"hidden\" name=\"searchtype\" value='$searchtype'>");
echo("<input type=\"hidden\" name=\"trigger\" value=2>");
echo("<div class=\"pull-right\">");
echo("<a href=\"#\" onclick=\"history.go(-1)\"><input type=\"button\"class=\"btn btn-primary\" value=\"Back\"></a> &nbsp");
echo("<button type=\"submit\" class=\"btn btn-primary\">Next</button>");
echo("</div>");
echo("</div>");
echo("</form>");
}
echo("</div>
<div class=\"col-md-6\"></br></div>");
}
if ($trigger == 2)
{
echo("<legend>Advanced Search</legend>");
$searchtype = $_POST["searchtype"];
$typeid = $_POST["type_id"];
		if ((!isSet($_POST["type_id"])))
		die("you must select a search type <a href=\"search.php\">Back</a>");

if ($searchtype == "RESULT")
{
echo("<table id=\"resulttable\" class=\"table table-hover table-bordered\">");
echo("<thead>");
echo("<tr><th>Date</th><th>Track</th><th>Runner</th><th>Result</th><th>Note</th></tr>");
echo("</thead>");
echo("<tbody>");
$sql = "SELECT vr.date,vr.track,vr.runner,vr.time,(CASE WHEN (vr.time = (SELECT min(time) FROM vw_results a WHERE a.track_id = vr.track_id AND a.runner_id = vr.runner_id)) THEN 'YES' END)  as pb from vw_results vr where vr.result_set_id = $typeid";
$result = mysqli_query($conn, $sql) or die("Error POSTting track list");
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
echo("</br>");
echo("<div class=\"pull-right\">");
echo("<a href=\"#\" onclick=\"history.go(-1)\"><input type=\"button\"class=\"btn btn-primary\" value=\"Back\"></a> &nbsp");
echo("<a href=\"search.php\"><input type=\"button\"class=\"btn btn-primary\" value=\"Home\"></a>");
echo("</div>");
}
if ($searchtype == "RUNNER")
{
echo("<table id=\"resulttable\" class=\"table table-hover table-bordered\">");
echo("<thead>");
echo("<tr><th>Date</th><th>Track</th><th>Runner</th><th>Result</th><th>Note</th></tr>");
echo("</thead>");
echo("<tbody>");
$sql = "SELECT vr.date,vr.track,vr.runner,vr.time,(CASE WHEN (vr.time = (SELECT min(a.time) FROM vw_results a WHERE a.track_id = vr.track_id AND a.runner_id = vr.runner_id)) THEN 'YES' END)  as pb from vw_results vr where vr.runner_id = $typeid";
$result = mysqli_query($conn, $sql) or die("Error POSTting track list");
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
echo("</br>");
echo("<div class=\"pull-right\">");
echo("<a href=\"#\" onclick=\"history.go(-1)\"><input type=\"button\"class=\"btn btn-primary\" value=\"Back\"></a> &nbsp");
echo("<a href=\"search.php\"><input type=\"button\"class=\"btn btn-primary\" value=\"Home\"></a>");
echo("</div>");






}

if($searchtype == "TRACK")
{

echo("<table id=\"resulttable\" class=\"table table-hover table-bordered\">");
echo("<thead>");
echo("<tr><th>Date</th><th>Track</th><th>Runner</th><th>Result</th><th>Note</th></tr>");
echo("</thead>");
echo("<tbody>");
$sql = "SELECT vr.date,vr.track,vr.runner,vr.time,(CASE WHEN (vr.time = (SELECT min(a.time) FROM vw_results a WHERE a.track_id = vr.track_id AND a.runner_id = vr.runner_id)) THEN 'YES' END)  as pb from vw_results vr where vr.track_id = $typeid";
$result = mysqli_query($conn, $sql) or die("Error POSTting track list");
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
echo("</br>");
echo("<div class=\"pull-right\">");
echo("</div>");




}		
		
		
		
		
}

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