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

							echo("<a  onclick=\"document.getElementById('useradmin').submit();\">useradmin</a></li>");
							}
							echo("</ul></div><div class=\"col-md-10\">");

	echo("<h3>Events Editor</h3>");
	echo("<form action=\"myevents\" method=\"get\">");
     
	 $trigger = $_GET["trigger"];
 
 //database connection
 include 'connection.php'; 
  // data functions
 include 'functions.php';


	
if ($trigger == 0) // just display insert plus current list
{
echo("<table style=\"width:75%\">");
echo("<tr><td>Event Name: </td><td><input type=\"text\" id=\"eventname\" name=\"eventname\" class=\"form-control\"></td></tr>");
echo("<tr><td>Event Date: </td><td><input type=\"text\" id=\"date\" name=\"date\" class=\"form-control\"></td></tr>");
echo("<tr><td>Event Link: </td><td><input type=\"text\" id=\"eventlink\" name=\"eventlink\" class=\"form-control\"></td></tr>");
echo("<tr><td>Comments: </td><td><textarea name=\"eventcomment\" class=\"texteditor form-control\" ></textarea></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</br></div></td></tr></table></form>");


$sql = "SELECT event_id, event_date,event_name,event_link FROM event";
echo("<br><table class=\"table table-bordered\"><tr><th>Date</th><th>Event</th><th>Link</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting news list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["event_date"]."</td><td>".$row["event_name"]."</td><td>".$row["event_link"]."</td><td><a href=myevents?trigger=2&eventid=".$row["event_id"]."&".SID.">Update</a></td><td><a href=myevents?trigger=3&eventid=".$row["event_id"]."&".SID." onClick=\"return confirm('Delete This event?')\">Delete</a></td></tr>");
	}
echo("</table>");
 
}	
 
if ($trigger == 1) //insert an event
{



echo("<table style=\"width:75%\">");
echo("<tr><td>Event Name: </td><td><input type=\"text\" id=\"eventname\" name=\"eventname\" class=\"form-control\"></td></tr>");
echo("<tr><td>Event Date: </td><td><input type=\"text\" id=\"date\" name=\"date\" class=\"form-control\"></td></tr>");
echo("<tr><td>Event Link: </td><td><input type=\"text\" id=\"eventlink\" name=\"eventlink\" class=\"form-control\" ></td></tr>");
echo("<tr><td>Comments: </td><td><textarea name=\"eventcomment\" class=\"texteditor form-control\" ></textarea></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</br></div></td></tr></table></form>");



		if ((!isSet($_GET["eventname"])) ||
		(!isSet($_GET["date"])) ||
		(!isSet($_GET["eventlink"])))
		die("A title, date and link must be entered for an event");
		
		
		$eventname = escape($conn,$_GET["eventname"]);
		$eventlink = $_GET["eventlink"];
		$comment = escape($conn,$_GET["eventcomment"]);
		$date = $_GET["date"];
		
		// process date stuff
		$todate = strtotime($date);
		$formated = date('y-m-d',$todate);
		str_replace("/","-",$formated);
		
		

		$sql = "INSERT INTO event(event_name, event_date,event_link,event_comments) VALUES ($eventname,'$formated','$eventlink',$comment)";
		$result = mysqli_query($conn,$sql) or die ("Error inserting record - ".mysqli_error($conn));
		
		if (mysqli_affected_rows($conn) != 1) 
		die("Error inserting event");

$sql = "SELECT event_id, event_date,event_name,event_link FROM event";
echo("<br><table class=\"table table-bordered\"><tr><th>Date</th><th>Event</th><th>Link</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting news list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["event_date"]."</td><td>".$row["event_name"]."</td><td>".$row["event_link"]."</td><td><a href=myevents?trigger=2&eventid=".$row["event_id"]."&".SID.">Update</a></td><td><a href=myevents?trigger=3&eventid=".$row["event_id"]."&".SID." onClick=\"return confirm('Delete This event?')\">Delete</a></td></tr>");
	}
echo("</table>");
}

if ($trigger == 2) // update an event
{
if (!isset($_GET["eventid"]))
	die("You need to select an event from the form");
$eventid = $_GET["eventid"];

$sql = "SELECT event_name,event_date,event_link,event_comments,event_id FROM event WHERE event_id = $eventid";
$result = mysqli_query($conn,$sql) or die("error fetching row from runnerDb - ".mysql_error($conn));

if (mysqli_num_rows($result) == 0)
				die("Error – record not found to edit");

while ($row = mysqli_fetch_array($result))
			{
				$event_name = $row["event_name"];
				$event_date = $row["event_date"];
				$event_link = $row["event_link"];
				$event_comments = $row["event_comments"];
			}
			
echo("<table style=\"width:75%\">");
echo("<tr><td>Event Name: </td><td><input type=\"text\" id=\"eventname\" name=\"eventname\" value=\"$event_name\" class=\"form-control\"></td></tr>");
echo("<tr><td>Event Date: </td><td><input type=\"text\" id=\"date\" name=\"date\" value=\"$event_date\" class=\"form-control\"></td></tr>");
echo("<tr><td>Event Link: </td><td><input type=\"text\" id=\"eventlink\" name=\"eventlink\" value=\"$event_link\" class=\"form-control\"></td></tr>");
echo("<tr><td>Comments: </td><td><textarea name=\"eventcomment\" class=\"texteditor form-control\" >$event_comments</textarea></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=4></td><td></td></tr>");
echo("<input type=hidden name=eventid value=$eventid >");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</br></div></td></tr></table></form>");
			
$sql = "SELECT event_id, event_date,event_name,event_link FROM event";
echo("<br><table class=\"table table-bordered\"><tr><th>Date</th><th>Event</th><th>Link</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting news list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["event_date"]."</td><td>".$row["event_name"]."</td><td>".$row["event_link"]."</td><td><a href=myevents?trigger=2&eventid=".$row["event_id"]."&".SID.">Update</a></td><td><a href=myevents?trigger=3&eventid=".$row["event_id"]."&".SID." onClick=\"return confirm('Delete This event?')\">Delete</a></td></tr>");
	}
echo("</table>");			

}

if ($trigger == 3) // delete an event
{

		echo("<table style=\"width:75%\">");
		echo("<tr><td>Event Name: </td><td><input type=\"text\" id=\"eventname\" name=\"eventname\" ></td></tr>");
		echo("<tr><td>Event Date: </td><td><input type=\"text\" id=\"date\" name=\"date\"></td></tr>");
		echo("<tr><td>Event Link: </td><td><input type=\"text\" id=\"eventlink\" name=\"eventlink\" ></td></tr>");
		echo("<tr><td>Comments: </td><td><textarea name=\"eventcomment\" class=\"texteditor\" ></textarea></td></tr>");
		echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
		echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
		echo("</br></div></td></tr></table></form>");


if (!isset($_GET['eventid']))
			die("you must select an event");
		$eventid = $_GET["eventid"];

$sql = "DELETE FROM event WHERE event_id = $eventid";
$result = mysqli_query($conn, $sql) or die("Error deleting record ".mysqli_error($conn));
$numrows = mysqli_affected_rows($conn);
	if ($numrows == 1)
	{
		
$sql = "SELECT event_id, event_date,event_name,event_link FROM event";
echo("<br><table class=\"table table-bordered\"><tr><th>Date</th><th>Event</th><th>Link</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting news list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["event_date"]."</td><td>".$row["event_name"]."</td><td>".$row["event_link"]."</td><td><a href=myevents?trigger=2&eventid=".$row["event_id"]."&".SID.">Update</a></td><td><a href=myevents?trigger=3&eventid=".$row["event_id"]."&".SID." onClick=\"return confirm('Delete This event?')\">Delete</a></td></tr>");
	}
echo("</table>");
		
	}
	else
	{
		echo "<p class=\"pageheading\">Delete NOT Successfull</p>"; 
$sql = "SELECT event_id, event_date,event_name,event_link FROM event";
echo("<br><table class=\"table table-bordered\"><tr><th>Date</th><th>Event</th><th>Link</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting news list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["event_date"]."</td><td>".$row["event_name"]."</td><td>".$row["event_link"]."</td><td><a href=myevents?trigger=2&eventid=".$row["event_id"]."&".SID.">Update</a></td><td><a href=myevents?trigger=3&eventid=".$row["event_id"]."&".SID." onClick=\"return confirm('Delete This event?')\">Delete</a></td></tr>");
	}
echo("</table>");
	}
}

if ($trigger == 4) // do update
{
		
		if ((!isSet($_GET["eventname"])) ||
		(!isSet($_GET["date"])) ||
		(!isSet($_GET["eventlink"])))
		die("A title, date and link must be entered for an event");
		
		
		$eventname = escape($conn,$_GET["eventname"]);
		$eventlink = $_GET["eventlink"];
		$comment = escape($conn,$_GET["eventcomment"]);
		$date = $_GET["date"];
		$eventid = $_GET["eventid"];
		
		// process date stuff
		$todate = strtotime($date);
		$formated = date('y-m-d',$todate);
		str_replace("/","-",$formated);
		
		
		$sql = "UPDATE event SET event_name = $eventname, event_date = '$formated', event_link = '$eventlink', event_comments = $comment WHERE event_id = $eventid";
		$result = mysqli_query($conn, $sql) or die("Error updating record ".mysqli_error($conn));
		$numrows = mysqli_affected_rows($conn);
		
		echo("<table style=\"width:75%\">");
		echo("<tr><td>Event Name: </td><td><input type=\"text\" id=\"eventname\" name=\"eventname\" class=\"form-control\"></td></tr>");
		echo("<tr><td>Event Date: </td><td><input type=\"text\" id=\"date\" name=\"date\" class=\"form-control\"></td></tr>");
		echo("<tr><td>Event Link: </td><td><input type=\"text\" id=\"eventlink\" name=\"eventlink\" class=\"form-control\"></td></tr>");
		echo("<tr><td>Comments: </td><td><textarea name=\"eventcomment\" class=\"texteditor form-control\" ></textarea></td></tr>");
		echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
		echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
		echo("</br></div></td></tr></table></form>");


		$sql = "SELECT event_id, event_date,event_name,event_link FROM event";
		echo("<br><table class=\"table table-bordered\"><tr><th>Date</th><th>Event</th><th>Link</th><th>Update</th><th>Delete</th><tr>");
		$result = mysqli_query($conn, $sql) or die("Error getting news list");
		while ($row = mysqli_fetch_array($result)) 
		{
			echo("<tr><td>".$row["event_date"]."</td><td>".$row["event_name"]."</td><td>".$row["event_link"]."</td><td><a href=myevents?trigger=2&eventid=".$row["event_id"]."&".SID.">Update</a></td><td><a href=myevents?trigger=3&eventid=".$row["event_id"]."&".SID." onClick=\"return confirm('Delete This event?')\">Delete</a></td></tr>");
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