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
<script>
  $(function() {
    $( "#date" ).datepicker({ dateFormat: "yy-mm-dd" });
  });
  </script>
	<title>RunnerApp v0.3</title>	
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

<?php
    if (isset($_SESSION["authenticated"]))
{

	echo("<div class=\"col-md-2\">");
	echo("<br>");
	echo("<ul class=\"nav nav-list\">
	<li class=\"nav-header\">Administration</li>
	<li class=\"active\"><a href=\"myrunner?trigger=0&".SID."\">runners</a></li>
	<!--<li><a href=\"resultwizard2?trigger=0&".SID."\">results</a></li> -->
	<li><a href=\"resultwizard2?trigger=0&".SID."\"> add results</a></li>
	<li><a href=\"selectresult?".SID."\">edit result</a></li>
	<li><a href=\"mytrack?trigger=0&".SID."\">tracks</a></li>
	<li><a href=\"mynews?trigger=0&".SID."\">news</a></li>
	<li><a href=\"myevents?trigger=0&".SID."\">events</a></li>
	<li><a href=\"mycontacts?trigger=0&".SID."\">contacts</a></li>
	<li><a href=\"myfrontpage?trigger=2&".SID."\">Homepage Admin</a></li>");
	IF ($_SESSION['role'] == 'SUPER')
	{
echo("<form id=\"useradmin\" method=\"post\" action=\"useradmin?".SID."\">");
								echo("<input type=\"hidden\" name=\"trigger\" value=\"0\" /> ");
								echo("</form>");
							//echo("<li><a href=\"useradmin?trigger=0&".SID."\">useradmin</a></li>");
							echo("<a  onclick=\"document.getElementById('useradmin').submit();\">useradmin</a></li>");
	}
	echo("</ul></div><div class=\"col-md-10\">");
echo("</br><legend>Add Results</legend>");


   $trigger = $_GET["trigger"];
   
 //database connection
 include 'connection.php'; 
   // data functions
 include 'functions.php'; 


   
   
if ($trigger == 0)
{

$sql1 = "SELECT track_id, track_name FROM track";
$sql2 = "SELECT runner_id, first_name, surname FROM runner order by first_name, surname";

$sql3 = "SELECT count(runner_id) as count FROM runner";
$result = mysqli_query($conn, $sql3) or die("Error getting track list");
$row = mysqli_fetch_array($result);
$count = $row["count"];

echo ("<form action=\"resultwizard2?".SID."\" method=\"get\">");
echo("<table class = \"table table-bordered\">");
echo("<div class=\"form-group\">");
echo("<tr><td><span>STEP 1:</span><label>Select date of run</label></td>");
echo("<td><input type=\"text\" id=\"date\" name=\"date\" class=\"form-control\"></td></tr>");
echo("<tr><td><span>STEP 2:</span><label>Select Track</label></td>");
echo ("<td><select name=\"track\" class=\"form-control\">");

//echo ("<option value=\"?\">Track</option>");
$result = mysqli_query($conn, $sql1) or die("Error getting track list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<option value=\"".$row["track_id"]."\">".$row["track_name"]."</option>");

	}
echo ("</select>");
echo("</td></tr>");
echo("<tr><td><span>STEP 3:</span><label align=\"right\">Select participating Runners</label></td>");
echo ("<td><select name=\"runner[]\" multiple=\"multiple\" size=\"$count\" class=\"form-control\">");


$result = mysqli_query($conn, $sql2) or die("Error getting runner list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<option value=\"".$row["runner_id"]."\">".$row["first_name"]." ".$row["surname"]."</option>");
	}
echo ("</select></td></tr></table>");
echo ("<input type =\"hidden\" name=\"trigger\" value=\"1\">");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Next</button>");
echo("</div>");// end of form group
//echo ("<input type=\"submit\" value=\"submit\">");
echo("</form>");
}
if ($trigger == 1)
{

// process date stuff
$date = $_GET["date"];
$todate = strtotime($date);
$formated = date('y-m-d',$todate);
str_replace("/","-",$formated);

//get track_id
$trackid = $_GET["track"];



$sql1 = "INSERT INTO result_set(track_id, result_date) VALUES ($trackid, '$formated')";
$result = mysqli_query($conn,$sql1) or die ("Error inserting result set record - ".mysqli_error($conn));
$resultSetId = mysqli_insert_id($conn);

		if (mysqli_affected_rows($conn) != 1) 
		die("Error inserting result set");

$sql1 = "SELECT track_name FROM track where track_id = $trackid";
$result = mysqli_query($conn, $sql1) or die("Error getting track name");
$row = mysqli_fetch_array($result);
$datedisplay = date('d-m-y',$todate);

echo("<Legend>Input results for ".$row["track_name"]." on ".$datedisplay."</Legend>");


//creates a list of IDs for consumption by the sql
$idarray = $_GET['runner'];
$count = count($idarray);
$ids = '(';
for ($i = 0; $i < $count; $i++)
  {
 $ids = $ids.$idarray[$i];
 if ($i < ($count - 1))
 {
 $ids = $ids.',';
 }
 if ($i == ($count - 1))
 {
 $ids = $ids.')';
 }
  }



$sql2= "SELECT runner, runner_id from vw_runner where runner_id in $ids";

echo ("<form action=\"resultwizard2?".SID."\" method=\"get\">");
echo ("<table class=\"table\"><tr><th></th><th>name</th><th>Hours</th><th>Minutes</th><th>Seconds</th></tr>");
$result = mysqli_query($conn, $sql2) or die("Error getting runner name");
while ($row = mysqli_fetch_array($result))
{
echo("<tr><td><input type=\"hidden\" name=\"id[]\" value=\"".$row["runner_id"]."\"/></td><td>".$row["runner"]."</td><td><input type=\"text\" class=\"form-control\" name=\"hours[]\"></td><td><input type=\"text\" name=\"mins[]\" class=\"form-control\"></td><td><input type=\"text\" name=\"secs[]\" class=\"form-control\"></td></tr>");
}
echo("</table><br>");
echo ("<input type =\"hidden\" name=\"resultSetId\" value=\"".$resultSetId."\">");

echo ("<input type =\"hidden\" name=\"trigger\" value=\"2\">");

echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save Results</button>");
echo("</form>");
}
if ($trigger == 2)
{
$resultsetid = $_GET['resultSetId'];
$runnerIdArray = $_GET['id'];
$hoursArray = $_GET['hours'];
$minutesArray =  $_GET['mins'];
$secondsArray =   $_GET['secs'];

$count = count($runnerIdArray);


for ($i = 0; $i < $count; $i++)
{
 $hoursArray[$i] = escape($conn,$hoursArray[$i]);
 $minutesArray[$i] = escape($conn,$minutesArray[$i]);
 $secondsArray[$i] = escape($conn,$secondsArray[$i]);
 
if ($hoursArray[$i] == null)
{
$hoursArray[$i] = 0;
}
if ($minutesArray[$i] == null)
{
$minutesArray[$i] = 0;
}
if($secondsArray[$i] == null)
{
$secondsArray[$i] = 0;
}

///NEED TO ACCOUNT FOR NULL VALUES
$sql = "INSERT INTO result(result_set_id, runner_id, result_hour, result_min, result_sec) VALUES ($resultsetid,$runnerIdArray[$i],$hoursArray[$i],$minutesArray[$i],$secondsArray[$i])";

$result = mysqli_query($conn,$sql) or die ("Error inserting record - ".mysqli_error($conn));
if (mysqli_affected_rows($conn) != 1) die("Error inserting results");
}

echo("<table class=\"table table-bordered\"");
echo("<tr><th>Date</th><th>Track</th><th>Runner</th><th>Result</th></tr>");

$sql = "SELECT date,track,runner,time from vw_results where result_set_id = $resultsetid order by time";
$result = mysqli_query($conn, $sql) or die("Error getting track list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><th>".$row["date"]."</th><th>".$row["track"]."</th><th>".$row["runner"]."</th><th>".$row["time"]."</th></tr>");
	}
echo("</table>");

}
mysqli_close($conn);
}
else
	{
		echo "I am sorry but this page is only available to admins who have <a href=\"login\">logged in</a>";
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