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
<link rel="stylesheet" type="text/css" href="css/jquery-te-1.4.0.css">
<script type="text/javascript" charset="utf-8" src="/DataTables/media/js/jquery.js"></script>
<script type="text/javascript" charset="utf-8" src="/DataTables/media/js/jquery-te-1.4.0.min.js"></script>

<script>
$(document).ready( function () {
    $(".texteditor").jqte();
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




echo("<h3>New Track</h3><form action=\"mytrack\" method=\"get\">");
echo("<div class=\"form-group\">");
echo("<table><tr><td style=\"text-align:right\">Track Name:</td><td>");
	
     $trigger = $_GET["trigger"];
	
 //database connection
 include 'connection.php'; 
 
 // data functions
 include 'functions.php'; 

	
if ($trigger == 0) // just display insert plus current list
{
			
echo("<input type=\"text\" id=\"trackname\" class=\"form-control\" name=\"trackname\"></td></tr>");
echo("<tr><td style=\"text-align:right\">length: </td><td><input type=\"text\" id=\"tracklength\" class=\"form-control\" name=\"tracklength\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Pubrun Course: </td><td><select  class=\"form-control\" id=\"pubrunflag\" name=\"pubrunflag\"><option value=\" \"> </option><option value=\"Y\">Yes</option><option value=\"N\">No</option></select></td></tr>");
echo("<tr><td style=\"text-align:right\">Link: </td><td><input type=\"text\" id=\"tracklink\" class=\"form-control\" name=\"tracklink\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Description: </td><td><textarea name=\"trackdescription\" class=\"texteditor\" rows=\"4\" cols=\"50\">add description </textarea></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</div>");
echo("</br></div></td></tr></table></form>");

$sql = "SELECT track_id, track_name , track_length FROM track";

echo("<table class=\"table table-bordered\"><tr><th>Name</th><th>Length</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting track list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["track_name"]."</td><td>".$row["track_length"]."</td><td><a href=mytrack?trigger=2&track=".$row["track_id"]."&".SID.">Update</a></td><td><a href=mytrack?trigger=3&track=".$row["track_id"]."&".SID." onClick=\"return confirm('Delete This account?')\" >Delete</a></td></tr>");
	}
echo("</table>");
	 
}	 
if ($trigger == 1) //insert a track
{

echo("<input type=\"text\" id=\"trackname\" class=\"form-control\" name=\"trackname\"></td></tr>");
echo("<tr><td style=\"text-align:right\">length: </td><td><input type=\"text\" id=\"tracklength\" class=\"form-control\" name=\"tracklength\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Pubrun Course: </td><td><select  class=\"form-control\" id=\"pubrunflag\" name=\"pubrunflag\"><option value=\" \"> </option><option value=\"Y\">Yes</option><option value=\"N\">No</option></select></td></tr>");
echo("<tr><td style=\"text-align:right\">Link: </td><td><input type=\"text\" id=\"tracklink\" class=\"form-control\" name=\"tracklink\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Description: </td><td><textarea name=\"trackdescription\" class=\"texteditor\" rows=\"4\" cols=\"50\">add description </textarea></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</div>");
echo("</br></div></td></tr></table></form>");


		if ((!isSet($_GET["trackname"])) ||
		(!isSet($_GET["tracklength"])))
		die("You must input both a first and last name");
		
		$trackname = escape($conn,$_GET["trackname"]);
		$tracklength = escape($conn,$_GET["tracklength"]);
		$tracklink = escape($conn,$_GET["tracklink"]);
		$pubrunflag = $_GET["pubrunflag"];
		$trackdescription = escape($conn,$_GET["trackdescription"]);

		$sql = "INSERT INTO track(track_name, track_length,pubrun_flag,track_link,track_description) VALUES ($trackname,$tracklength,'$pubrunflag',$tracklink,$trackdescription)";
		$result = mysqli_query($conn,$sql) or die ("Error inserting record - ".mysqli_error($conn));
		
		if (mysqli_affected_rows($conn) != 1) 
		die("Error inserting track");

$sql = "SELECT track_id, track_name , track_length FROM track";

echo("<table class=\"table table-bordered\"><tr><th>Name</th><th>Length</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting track list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["track_name"]."</td><td>".$row["track_length"]."</td><td><a href=mytrack?trigger=2&track=".$row["track_id"]."&".SID.">Update</a></td><td><a href=mytrack?trigger=3&track=".$row["track_id"]."&".SID." onClick=\"return confirm('Delete This account?')\" >Delete</a></td></tr>");
	}
echo("</table>");
}
if ($trigger == 2) // update a track
{
if (!isset($_GET["track"]))
	die("You need to select a track from the form");
$track_id = $_GET["track"];

$sql = "SELECT track_name, track_length, track_link, track_description, pubrun_flag FROM track WHERE track_id = $track_id";
$result = mysqli_query($conn,$sql) or die("error fetching row from runnerDb - ".mysql_error($conn));

if (mysqli_num_rows($result) == 0)
				die("Error – record not found to edit");

while ($row = mysqli_fetch_array($result))
			{
				$track_name = $row["track_name"];
				$track_length = $row["track_length"];
				$tracklink = $row["track_link"];
				$trackdescription = $row["track_description"];
				$pubrunflag = $row["pubrun_flag"];
			}

echo("<input type=\"text\" id=\"trackname\" class=\"form-control\" name=\"trackname\" value=\"$track_name\"></td></tr>");
echo("<tr><td style=\"text-align:right\">length: </td><td><input type=\"text\" id=\"tracklength\" class=\"form-control\" name=\"tracklength\" value=\"$track_length\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Pubrun Course: </td><td><select  class=\"form-control\" id=\"pubrunflag\" name=\"pubrunflag\"><option value=\" \"> </option>");
IF($pubrunflag == 'Y')
{
	echo("<option value=\"Y\" selected>Yes</option><option value=\"N\">No</option></select></td></tr>");
}
ELSE
{
	echo("<option value=\"Y\">Yes</option><option value=\"N\" selected>No</option></select></td></tr>");
}
echo("<tr><td style=\"text-align:right\">Link: </td><td><input type=\"text\" id=\"tracklink\" class=\"form-control\" name=\"tracklink\" value=\"$tracklink\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Description: </td><td><textarea name=\"trackdescription\" class=\"texteditor\" rows=\"4\" cols=\"50\">$trackdescription</textarea></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=4></td><td></td></tr>");
echo("<input type=hidden name=track value=$track_id >");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">UPDATE</button>");
echo("</div>");
echo("</br></div></td></tr></table></form>");




$sql = "SELECT track_id, track_name , track_length FROM track";

echo("<table class=\"table table-bordered\"><tr><th>Name</th><th>Length</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting track list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["track_name"]."</td><td>".$row["track_length"]."</td><td><a href=mytrack?trigger=2&track=".$row["track_id"]."&".SID.">Update</a></td><td><a href=mytrack?trigger=3&track=".$row["track_id"]."&".SID." onClick=\"return confirm('Delete This account?')\" >Delete</a></td></tr>");
	}
echo("</table>");
}
if ($trigger == 3) // delete a track
{

echo("<input type=\"text\" id=\"trackname\" class=\"form-control\" name=\"trackname\"></td></tr>");
echo("<tr><td style=\"text-align:right\">length: </td><td><input type=\"text\" id=\"tracklength\" class=\"form-control\" name=\"tracklength\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Pubrun Course: </td><td><select  class=\"form-control\" id=\"pubrunflag\" name=\"pubrunflag\"><option value=\" \"> </option><option value=\"Y\">Yes</option><option value=\"N\">No</option></select></td></tr>");
echo("<tr><td style=\"text-align:right\">Link: </td><td><input type=\"text\" id=\"tracklink\" class=\"form-control\" name=\"tracklink\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Description: </td><td><textarea name=\"trackdescription\" class=\"texteditor\" rows=\"4\" cols=\"50\">add description </textarea></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</div>");
echo("</br></div></td></tr></table></form>");

if (!isset($_GET["track"]))
	die("You need to select a track from the form");
$track_id = $_GET["track"];

$sql = "DELETE FROM track WHERE track_id = $track_id";
$result = mysqli_query($conn, $sql) or die("Error deleting record ".mysqli_error($conn));
	$numrows = mysqli_affected_rows($conn);
	if ($numrows == 1)
	{
		
	$sql = "SELECT track_id, track_name FROM track";

	echo("<table class=\"table table-bordered\"><tr><th>Name</th><th>Update</th><th>Delete</th><tr>");
	$result = mysqli_query($conn, $sql) or die("Error getting track list");
	while ($row = mysqli_fetch_array($result)) 
		{
			echo("<tr><td>".$row["track_name"]."</td><td><a href=mytrack?trigger=2&track=".$row["track_id"]."&".SID.">Update</a></td><td><a href=mytrack?trigger=3&track=".$row["track_id"]."&".SID." onClick=\"return confirm('Delete This account?')\" >Delete</a></td></tr>");
		}
echo("</table>");
		
	}
	else
	{
		echo "<p class=\"pageheading\">Delete NOT Successfull</p>"; 
		$sql = "SELECT track_id, track_name FROM track";

		echo("<table class=\"table table-bordered\"><tr><th>Name</th><th>Update</th><th>Delete</th><tr>");
			$result = mysqli_query($conn, $sql) or die("Error getting track list");
		while ($row = mysqli_fetch_array($result)) 
		{
			echo("<tr><td>".$row["track_name"]."</td><td><a href=mytrack?trigger=2&track=".$row["track_id"]."&".SID.">Update</a></td><td><a href=mytrack?trigger=3&track=".$row["track_id"]."&".SID." onClick=\"return confirm('Delete This account?')\" >Delete</a></td></tr>");
		}
		echo("</table>");
		}
}
if ($trigger == 4) // do update
{
		if (!isset($_GET['trackname'])||!isset($_GET['tracklength']))
		die("You need to input a name and length for the track ");
		
		$track_name = escape($conn,$_GET["trackname"]);
		$track_length = escape($conn,$_GET["tracklength"]);
		$tracklink = escape($conn,$_GET["tracklink"]);
		$trackdescription = escape($conn,$_GET["trackdescription"]);
		$track_length = intval($track_length);
		$pubrunflag = $_GET["pubrunflag"];
		$track_id = $_GET["track"];
		
		$sql = "UPDATE track SET track_name = $track_name,track_length = $track_length, track_link = $tracklink, track_description = $trackdescription, pubrun_flag = '$pubrunflag' WHERE track_id = $track_id";
		$result = mysqli_query($conn, $sql) or die("Error updating record ".mysqli_error($conn));
		$numrows = mysqli_affected_rows($conn);
		
echo("<input type=\"text\" id=\"trackname\" class=\"form-control\" name=\"trackname\"></td></tr>");
echo("<tr><td style=\"text-align:right\">length: </td><td><input type=\"text\" id=\"tracklength\" class=\"form-control\" name=\"tracklength\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Pubrun Course: </td><td><select  class=\"form-control\" id=\"pubrunflag\" name=\"pubrunflag\"><option value=\" \"> </option><option value=\"Y\">Yes</option><option value=\"N\">No</option></select></td></tr>");
echo("<tr><td style=\"text-align:right\">Link: </td><td><input type=\"text\" id=\"tracklink\" class=\"form-control\" name=\"tracklink\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Description: </td><td><textarea name=\"trackdescription\" class=\"texteditor\" rows=\"4\" cols=\"50\">add description </textarea></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</div>");
echo("</br></div></td></tr></table></form>");
		
$sql = "SELECT track_id, track_name , track_length FROM track";

echo("<table class=\"table table-bordered\"><tr><th>Name</th><th>Length</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting track list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["track_name"]."</td><td>".$row["track_length"]."</td><td><a href=mytrack?trigger=2&track=".$row["track_id"]."&".SID.">Update</a></td><td><a href=mytrack?trigger=3&track=".$row["track_id"]."&".SID." onClick=\"return confirm('Delete This account?')\" >Delete</a></td></tr>");
	}
echo("</table>");
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