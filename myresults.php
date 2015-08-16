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
<style type="text/css">
.texteditor{width:75%;}
</style>
<body>
	<div class="container-fluid">
		<div class ="row">
			<div class ="col-md-1">
			</div>
			<div class ="col-md-10" id="pagemain"  >
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
     //$trigger = $_POST["trigger"];
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
							echo("</ul></div><div class=\"col-md-10\"></br>");
	 
 //database connection
 include 'connection.php';
// data functions
 include 'functions.php'; 


	
$trigger = $_POST["trigger"];

$resultsetid = $_POST["resultsetid"];





if ($trigger == 0) // just display insert plus current list
{

$sql = "select runner, runner_id from vw_runner where runner_id NOT IN (SELECT runner_id from vw_results where result_set_id = $resultsetid)";
$result = mysqli_query($conn, $sql) or die("Error POSTting track list");
echo ("<form action=\"myresults\" method=\"post\">");			
echo("<table style=\"width:75%\">");
echo("<td style=\"text-align:right\">Runner: </td><td><select class=\"form-control\" name=\"runner\" id=\"runner\">");							
while ($row = mysqli_fetch_array($result)) 
	{
	echo("<option value=\"".$row["runner_id"]."\">".$row["runner"]."</option>");
	}
	echo("</select></td></tr>");
echo("<tr><td style=\"text-align:right\">Hours: </td><td><input type=\"text\" class=\"form-control\" id=\"hours\" name=\"hours\" ></td></tr>");
echo("<tr><td style=\"text-align:right\">Mins: </td><td><input type=\"text\" class=\"form-control\" id=\"mins\" name=\"mins\" ></td></tr>");
echo("<tr><td style=\"text-align:right\">Secs: </td><td><input type=\"text\" class=\"form-control\" id=\"secs\" name=\"secs\" ></td></tr>");
echo("<tr><td style=\"text-align:right\"><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</br></div></td></tr></table></form></br>");
echo("<table id=\"resulttable\" class=\"table table-hover table-bordered\">");
echo("<thead>");
echo("<tr><th>Date</th><th>Track</th><th>Runner</th><th>Result</th><th>Update</th><th>Delete</th></tr>");
echo("</thead>");
echo("<tbody>");
$sql = "SELECT result_id,date,track,runner,time from vw_results where result_set_id = $resultsetid order by time";
$result = mysqli_query($conn, $sql) or die("Error POSTting track list");
while ($row = mysqli_fetch_array($result)) 
	{
	$resultid = $row["result_id"];
	
	//update form for post method
	$update = "update".$resultid;

	echo("<form id=\"$update\" method=\"post\" action=\"myresults\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"2\" /> ");
	echo("<input type=\"hidden\" name=\"result_id\" value=\"$resultid\" /> ");
	echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
	echo("</form>");	;
    
	
	//delete form for post method
    $delete = "delete".$resultid;

	echo("<form id=\"$delete\" method=\"post\" action=\"myresults\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"3\" /> ");
	echo("<input type=\"hidden\" name=\"result_id\" value=\"$resultid\" /> ");
	echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
	echo("</form>");		
	
	echo("<tr><td>".$row["date"]."</td><td>".$row["track"]."</td><td>".$row["runner"]."</td><td>".$row["time"]."</td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$update').submit();\">UPDATE</button></td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$delete').submit();\">DELETE</button></td></tr>");
	}
echo("</tbody>");
echo("</table>");
}

if ($trigger == 1) // insert
{

///check values
		if ((!isSet($_POST["runner"]))||
		(!isSet($_POST["hours"]))||
		(!isSet($_POST["mins"]))||
		(!isSet($_POST["secs"])))
		die("All Fields are Mandatory");

//GET values by POST method

$resultsetid =  $_POST["resultsetid"];
$hour = escape($conn,$_POST["hours"]);
$minute = escape($conn,$_POST["mins"]);
$second = escape($conn,$_POST["secs"]);
$runner = $_POST["runner"];


// set empty times to zero

if ($hour == null)
{
$hour = 0;
}
if ($minute == null)
{
$minute = 0;
}
if($second == null)
{
$second = 0;
}

// insert runner result
$insertsql = "INSERT INTO result(result_set_id,runner_id,result_hour,result_min,result_sec) VALUES ($resultsetid,$runner,$hour,$minute,$second)";
$result = mysqli_query($conn,$insertsql) or die ("Error inserting runner result - ".mysqli_error($conn));
if (mysqli_affected_rows($conn) != 1) die("Error inserting user");



$sql = "select runner, runner_id from vw_runner where runner_id NOT IN (SELECT runner_id from vw_results where result_set_id = $resultsetid)";
$result = mysqli_query($conn, $sql) or die("Error POSTting track list");
echo ("<form action=\"myresults\" method=\"post\">");			
echo("<table style=\"width:75%\">");
echo("<td style=\"text-align:right\">Runner: </td><td><select class=\"form-control\" name=\"runner\" id=\"runner\">");						
while ($row = mysqli_fetch_array($result)) 
	{
	echo("<option value=\"".$row["runner_id"]."\">".$row["runner"]."</option>");
	}
	echo("</select></td></tr>");
echo("<tr><td style=\"text-align:right\">Hours: </td><td><input type=\"text\" class=\"form-control\" id=\"hours\" name=\"hours\" ></td></tr>");
echo("<tr><td style=\"text-align:right\">Mins: </td><td><input type=\"text\" class=\"form-control\" id=\"mins\" name=\"mins\" ></td></tr>");
echo("<tr><td style=\"text-align:right\">Secs: </td><td><input type=\"text\" class=\"form-control\" id=\"secs\" name=\"secs\" ></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</br></div></td></tr></table></form></br>");


echo("<table id=\"resulttable\" class=\"table table-hover table-bordered\">");
echo("<thead>");
echo("<tr><th>Date</th><th>Track</th><th>Runner</th><th>Result</th><th>Update</th><th>Delete</th></tr>");
echo("</thead>");
echo("<tbody>");
$sql = "SELECT result_id,date,track,runner,time from vw_results where result_set_id = $resultsetid order by time";
$result = mysqli_query($conn, $sql) or die("Error POSTting track list");
while ($row = mysqli_fetch_array($result)) 
	{
	$resultid = $row["result_id"];
	
	//update form for post method
	$update = "update".$resultid;
	//echo("$update");
	echo("<form id=\"$update\" method=\"post\" action=\"myresults\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"2\" /> ");
	echo("<input type=\"hidden\" name=\"result_id\" value=\"$resultid\" /> ");
	echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
	echo("</form>");	;
    
	
	//delete form for post method
    $delete = "delete".$resultid;
	//echo("$delete");	
	echo("<form id=\"$delete\" method=\"post\" action=\"myresults\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"3\" /> ");
	echo("<input type=\"hidden\" name=\"result_id\" value=\"$resultid\" /> ");
	echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
	echo("</form>");		
	
	echo("<tr><td>".$row["date"]."</td><td>".$row["track"]."</td><td>".$row["runner"]."</td><td>".$row["time"]."</td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$update').submit();\">UPDATE</button></td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$delete').submit();\">DELETE</button></td></tr>");

	}
echo("</tbody>");
echo("</table>");
}











if ($trigger == 2) // update a result
{
if (!isset($_POST["result_id"]))
	die("You need to select an event from the form");
$result_id = $_POST["result_id"];


//echo("<h4>debug result_id = $result_id </h4>");

$sql = "select v.result_id,v.result_date,v.runner,v.track,r.result_hour,r.result_min,r.result_sec from result r join vw_results v on r.result_id = v.result_id WHERE v.result_id = $result_id";
$result = mysqli_query($conn,$sql) or die("error fetching row from runnerDb - ".mysql_error($conn));

if (mysqli_num_rows($result) == 0)
				die("Error – record not found to edit");

while ($row = mysqli_fetch_array($result))
			{
				$runner = $row["runner"];
				$track = $row["track"];
				$date = $row["result_date"];
				$hour = $row["result_hour"];
				$min = $row["result_min"];
				$sec = $row["result_sec"];
				//$result_id = $row["result_id"];
			}
			
echo("<Legend>Time for $runner at $track on $date</Legend>");
echo ("<form action=\"myresults\" method=\"post\">");			
echo("<table style=\"width:75%\">");
echo("<tr><td style=\"text-align:right\">Hours: </td><td><input type=\"text\" class=\"form-control\" id=\"hours\" name=\"hours\" value=\"$hour\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Mins: </td><td><input type=\"text\" class=\"form-control\" id=\"mins\" name=\"mins\" value=\"$min\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Secs: </td><td><input type=\"text\" class=\"form-control\" id=\"secs\" name=\"secs\" value=\"$sec\"></td></tr>");
echo("<tr><td style=\"text-align:right\"><input type=\"hidden\" name=\"trigger\" value=4></td><td></td></tr>");
echo("<input type=\"hidden\" name=\"result_id\" value=\"$result_id\" >");
echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</br></div></td></tr></table></form>");
			
echo("<table id=\"resulttable\" class=\"table table-hover table-bordered\">");
echo("<thead>");
echo("<tr><th>Date</th><th>Track</th><th>Runner</th><th>Result</th><th>Update</th><th>Delete</th></tr>");
echo("</thead>");
echo("<tbody>");
$sql = "SELECT result_id,date,track,runner,time from vw_results where result_set_id = $resultsetid order by time";
$result = mysqli_query($conn, $sql) or die("Error POSTting track list");
while ($row = mysqli_fetch_array($result)) 
	{
	$resultid = $row["result_id"];
	
	//update form for post method
	$update = "update".$resultid;

	echo("<form id=\"$update\" method=\"post\" action=\"myresults\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"2\" /> ");
	echo("<input type=\"hidden\" name=\"result_id\" value=\"$resultid\" /> ");
	echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
	echo("</form>");	;
    
	
	//delete form for post method
    $delete = "delete".$resultid;

	echo("<form id=\"$delete\" method=\"post\" action=\"myresults\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"3\" /> ");
	echo("<input type=\"hidden\" name=\"result_id\" value=\"$resultid\" /> ");
	echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
	echo("</form>");	
	
	echo("<tr><td>".$row["date"]."</td><td>".$row["track"]."</td><td>".$row["runner"]."</td><td>".$row["time"]."</td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$update').submit();\">UPDATE</button></td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$delete').submit();\">DELETE</button></td></tr>");

	}
echo("</tbody>");
echo("</table>");	

}



if ($trigger == 3) // delete a result
{

if (!isset($_POST["result_id"]))
			die("you must select an event");
		$result_id = $_POST["result_id"];
		

$sql = "select runner, runner_id from vw_runner where runner_id NOT IN (SELECT runner_id from vw_results where result_set_id = $resultsetid)";
$result = mysqli_query($conn, $sql) or die("Error POSTting track list");
echo ("<form action=\"myresults\" method=\"post\">");			
echo("<table style=\"width:75%\">");
echo("<td style=\"text-align:right\">Runner: </td><td><select class=\"form-control\" name=\"runner\" id=\"runner\">");						
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<option value=\"".$row["runner_id"]."\">".$row["runner"]."</option>");
	}
	echo("</select></td></tr>");
echo("<tr><td style=\"text-align:right\">Hours: </td><td><input type=\"text\" class=\"form-control\" id=\"hours\" name=\"hours\" ></td></tr>");
echo("<tr><td style=\"text-align:right\">Mins: </td><td><input type=\"text\" class=\"form-control\" id=\"mins\" name=\"mins\" ></td></tr>");
echo("<tr><td style=\"text-align:right\">Secs: </td><td><input type=\"text\" class=\"form-control\" id=\"secs\" name=\"secs\" ></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</br></div></td></tr></table></form></br>");

		
$sql = "DELETE FROM result WHERE result_id = $result_id";
$result = mysqli_query($conn, $sql) or die("Error deleting record ".mysqli_error($conn));
$numrows = mysqli_affected_rows($conn);
	if ($numrows == 1)
	{
		echo("<table id=\"resulttable\" class=\"table table-hover table-bordered\">");
echo("<thead>");
echo("<tr><th>Date</th><th>Track</th><th>Runner</th><th>Result</th><th>Update</th><th>Delete</th></tr>");
echo("</thead>");
echo("<tbody>");
$sql = "SELECT result_id,date,track,runner,time from vw_results where result_set_id = $resultsetid order by time";
$result = mysqli_query($conn, $sql) or die("Error POSTting track list");
while ($row = mysqli_fetch_array($result)) 
	{
	$resultid = $row["result_id"];
	
	//update form for post method
	$update = "update".$resultid;

	echo("<form id=\"$update\" method=\"post\" action=\"myresults\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"2\" /> ");
	echo("<input type=\"hidden\" name=\"result_id\" value=\"$resultid\" /> ");
	echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
	echo("</form>");	;
    
	
	//delete form for post method
    $delete = "delete".$resultid;

	echo("<form id=\"$delete\" method=\"post\" action=\"myresults\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"3\" /> ");
	echo("<input type=\"hidden\" name=\"result_id\" value=\"$resultid\" /> ");
	echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
	echo("</form>");	
	
	echo("<tr><td>".$row["date"]."</td><td>".$row["track"]."</td><td>".$row["runner"]."</td><td>".$row["time"]."</td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$update').submit();\">UPDATE</button></td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$delete').submit();\">DELETE</button></td></tr>");

	}
echo("</tbody>");
echo("</table>");
	}
	else
	{
		echo("<table id=\"resulttable\" class=\"table table-hover table-bordered\">");
echo("<thead>");
echo("<tr><th>Date</th><th>Track</th><th>Runner</th><th>Result</th><th>Update</th><th>Delete</th></tr>");
echo("</thead>");
echo("<tbody>");
$sql = "SELECT result_id,date,track,runner,time from vw_results where result_set_id = $resultsetid order by time";
$result = mysqli_query($conn, $sql) or die("Error POSTting track list");
while ($row = mysqli_fetch_array($result)) 
	{
	$resultid = $row["result_id"];
	
	//update form for post method
	$update = "update".$resultid;

	echo("<form id=\"$update\" method=\"post\" action=\"myresults\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"2\" /> ");
	echo("<input type=\"hidden\" name=\"result_id\" value=\"$resultid\" /> ");
	echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
	echo("</form>");	;
    
	
	//delete form for post method
    $delete = "delete".$resultid;

	echo("<form id=\"$delete\" method=\"post\" action=\"myresults\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"3\" /> ");
	echo("<input type=\"hidden\" name=\"result_id\" value=\"$resultid\" /> ");
	echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
	echo("</form>");	
	
	echo("<tr><td>".$row["date"]."</td><td>".$row["track"]."</td><td>".$row["runner"]."</td><td>".$row["time"]."</td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$update').submit();\">UPDATE</button></td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$delete').submit();\">DELETE</button></td></tr>");

	}
echo("</tbody>");
echo("</table>");
}
}

if ($trigger == 4) // do update
{
		
		if ((!isSet($_POST["hours"])) ||
		(!isSet($_POST["mins"])) ||
		(!isSet($_POST["secs"])))
		die("At least enter an hour or minute or second");
		
		
		$hours = escape($conn,$_POST["hours"]);
		$mins = escape($conn,$_POST["mins"]);
		$secs = escape($conn,$_POST["secs"]);
		$result_id = $_POST["result_id"];
		
		// process null values
		
		if ($hours == null)
		{
			$hours = 0;
		}
		if ($mins == null)
		{
			$mins = 0;
		}
		if($secs == null)
		{
			$secs = 0;
		}
			
		$sql = "UPDATE result SET result_hour = $hours, result_min = $mins, result_sec = $secs  WHERE result_id = $result_id";
		$result = mysqli_query($conn, $sql) or die("Error updating record ".mysqli_error($conn));
		$numrows = mysqli_affected_rows($conn);

$sql = "select runner, runner_id from vw_runner where runner_id NOT IN (SELECT runner_id from vw_results where result_set_id = $resultsetid)";
$result = mysqli_query($conn, $sql) or die("Error POSTting track list");
echo ("<form action=\"myresults\" method=\"post\">");			
echo("<table style=\"width:75%\">");
echo("<td style=\"text-align:right\">Runner: </td><td><select class=\"form-control\" name=\"runner\" id=\"runner\">");							
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<option value=\"".$row["runner_id"]."\">".$row["runner"]."</option>");
	}
	echo("</select></td></tr>");
echo("<tr><td style=\"text-align:right\">Hours: </td><td><input type=\"text\" class=\"form-control\" id=\"hours\" name=\"hours\" ></td></tr>");
echo("<tr><td style=\"text-align:right\">Mins: </td><td><input type=\"text\" class=\"form-control\" id=\"mins\" name=\"mins\" ></td></tr>");
echo("<tr><td style=\"text-align:right\">Secs: </td><td><input type=\"text\" class=\"form-control\" id=\"secs\" name=\"secs\" ></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</br></div></td></tr></table></form></br>");
		
echo("<table id=\"resulttable\" class=\"table table-hover table-bordered\">");
echo("<thead>");
echo("<tr><th>Date</th><th>Track</th><th>Runner</th><th>Result</th><th>Update</th><th>Delete</th></tr>");
echo("</thead>");
echo("<tbody>");
$sql = "SELECT result_id,date,track,runner,time from vw_results where result_set_id = $resultsetid";
$result = mysqli_query($conn, $sql) or die("Error POSTting track list");
while ($row = mysqli_fetch_array($result)) 
	{
	$resultid = $row["result_id"];
	
	//update form for post method
	$update = "update".$resultid;
	//echo("$update");
	echo("<form id=\"$update\" method=\"post\" action=\"myresults\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"2\" /> ");
	echo("<input type=\"hidden\" name=\"result_id\" value=\"$resultid\" /> ");
	echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
	echo("</form>");	;
    
	
	//delete form for post method
    $delete = "delete".$resultid;
	//echo("$delete");	
	echo("<form id=\"$delete\" method=\"post\" action=\"myresults\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"3\" /> ");
	echo("<input type=\"hidden\" name=\"result_id\" value=\"$resultid\" /> ");
	echo("<input type=\"hidden\" name=\"resultsetid\" value=\"$resultsetid\" /> ");
	echo("</form>");	
	
	echo("<tr><td>".$row["date"]."</td><td>".$row["track"]."</td><td>".$row["runner"]."</td><td>".$row["time"]."</td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$update').submit();\">UPDATE</button></td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$delete').submit();\">DELETE</button></td></tr>");

	}
echo("</tbody>");
echo("</table>");	
		
		
}
/*
*/
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