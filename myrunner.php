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
								echo("<a  onclick=\"document.getElementById('useradmin').submit();\">useradmin</a></li>");
	}
	echo("</ul></div><div class=\"col-md-10\">");



echo("<h3>New Runner</h3><form action=\"myrunner\" method=\"get\">
	<table><tr><td>First Name:</td><td>");

     $trigger = $_GET["trigger"];
	 
 //database connection
 include 'connection.php'; 
 
  // data functions
 include 'functions.php'; 


	
if ($trigger == 0) // just display insert plus current list
{
				
echo("<input type=\"text\" id=\"firstname\" name=\"firstname\" class=\"form-control\"></td></tr><tr>");
echo("<td>Surname: </td><td><input type=\"text\" id=\"surname\" name=\"surname\" class=\"form-control\"></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");

echo("</br></div></td></tr></table></form>");

$sql = "SELECT runner_id, first_name, surname FROM runner";
echo("<br><table class=\"table table-bordered\"><tr><th>Name</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting runner list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["first_name"]." ".$row["surname"]."</td><td><a href=myrunner?trigger=2&runner=".$row["runner_id"]."&".SID.">Update</a></td><td><a href=myrunner?trigger=3&runner=".$row["runner_id"]."&".SID." onClick=\"return confirm('Delete This account?')\">Delete</a></td></tr>");
	}
echo("</table>");
	 
}	 
if ($trigger == 1) //insert a runner
{

echo("<input type=\"text\" id=\"firstname\" name=\"firstname\" class=\"form-control\"></td></tr><tr>");
echo("<td>Surname: </td><td><input type=\"text\" id=\"surname\" name=\"surname\" class=\"form-control\"></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</br></div></td></tr></table></form>");


		if ((!isSet($_GET["firstname"])) ||
		(!isSet($_GET["surname"])))
		die("You must input both a first and last name");
		
		$firstname = escape($conn,$_GET["firstname"]);
		$surname = escape($conn,$_GET["surname"]);
		
		
		$sql = "INSERT INTO runner(first_name, surname) VALUES ($firstname,$surname)";
		$result = mysqli_query($conn,$sql) or die ("Error inserting record - ".mysqli_error($conn));
		
		if (mysqli_affected_rows($conn) != 1) 
		die("Error inserting runner");

$sql = "SELECT runner_id, first_name, surname FROM runner";


echo("<br><table class=\"table table-bordered\"><tr><th>Name</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting runner list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["first_name"]." ".$row["surname"]."</td><td><a href=myrunner?trigger=2&runner=".$row["runner_id"]."&".SID.">Update</a></td><td><a href=myrunner?trigger=3&runner=".$row["runner_id"]."&".SID." onClick=\"return confirm('Delete This account?')\">Delete</a></td></tr>");
	}
echo("</table>");
}
if ($trigger == 2) // update a runner
{
if (!isset($_GET["runner"]))
	die("You need to select a product from the form");
$runner_id = $_GET["runner"];

$sql = "SELECT first_name, surname FROM runner WHERE runner_id = $runner_id";
$result = mysqli_query($conn,$sql) or die("error fetching row from runnerDb - ".mysql_error($conn));

if (mysqli_num_rows($result) == 0)
				die("Error – record not found to edit");

while ($row = mysqli_fetch_array($result))
			{
				$first_name = $row["first_name"];
				$surname = $row["surname"];
			}
echo("<input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"$first_name\" class=\"form-control\"></td></tr><tr>");
echo("<td>Surname: </td><td><input type=\"text\" id=\"surname\" name=\"surname\" value=\"$surname\" class=\"form-control\"></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=4></td><td></td></tr>");
echo("<input type=hidden name=runner value=$runner_id >");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">UPDATE</button>");
echo("</br></div></td></tr></table></form>");

$sql = "SELECT runner_id, first_name, surname FROM runner";

echo("<br><table class=\"table table-bordered\"><tr><th>Name</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting runner list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["first_name"]." ".$row["surname"]."</td><td><a href=myrunner?trigger=2&runner=".$row["runner_id"]."&".SID.">Update</a></td><td><a href=myrunner?trigger=3&runner=".$row["runner_id"]."&".SID." onClick=\"return confirm('Delete This account?')\">Delete</a></td></tr>");
	}
echo("</table>");
}
if ($trigger == 3) // delete a runner
{

echo("<input type=\"text\" id=\"firstname\" name=\"firstname\" class=\"form-control\"></td></tr><tr>");
echo("<td>Surname: </td><td><input type=\"text\" id=\"surname\" name=\"surname\" class=\"form-control\"></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</br></div></td></tr></table></form>");

if (!isset($_GET['runner']))
			die("you must select a runner ");
$runner_id = $_GET["runner"];

$sql = "DELETE FROM runner WHERE runner_id = $runner_id";
$result = mysqli_query($conn, $sql) or die("Error deleting record ".mysqli_error($conn));
$numrows = mysqli_affected_rows($conn);
	if ($numrows == 1)
	{
		
		$sql = "SELECT runner_id, first_name, surname FROM runner";
		echo("<br><table class=\"table table-bordered\"><tr><th>Name</th><th>Update</th><th>Delete</th><tr>");
		$result = mysqli_query($conn, $sql) or die("Error getting runner list");
		while ($row = mysqli_fetch_array($result)) 
		{
			echo("<tr><td>".$row["first_name"]." ".$row["surname"]."</td><td><a href=myrunner?trigger=2&runner=".$row["runner_id"]."&".SID.">Update</a></td><td><a href=myrunner?trigger=3&runner=".$row["runner_id"]."&".SID." onClick=\"return confirm('Delete This account?')\">Delete</a></td></tr>");
		}
echo("</table>");
		
	}
	else
	{
		echo "<p class=\"pageheading\">Delete NOT Successfull</p>"; 
		$sql = "SELECT runner_id, first_name, surname FROM runner";
		echo("<br><table class=\"table table-bordered\"><tr><th>Name</th><th>Update</th><th>Delete</th><tr>");
		$result = mysqli_query($conn, $sql) or die("Error getting runner list");
		while ($row = mysqli_fetch_array($result)) 
		{
			echo("<tr><td>".$row["first_name"]." ".$row["surname"]."</td><td><a href=myrunner?trigger=2&runner=".$row["runner_id"]."&".SID.">Update</a></td><td><a href=myrunner?trigger=3&runner=".$row["runner_id"]."&".SID." onClick=\"return confirm('Delete This account?')\">Delete</a></td></tr>");
		}
echo("</table>");
	}
}
if ($trigger == 4) // do update
{
		if ((!isSet($_GET["firstname"])) ||
		(!isSet($_GET["surname"])))
		die("You must input both a first and last name");
		
		$runner_id = $_GET["runner"];
		$firstname = escape($conn,$_GET["firstname"]);
		$surname = escape($conn,$_GET["surname"]);
		
		$sql = "UPDATE runner SET first_name = $firstname,surname = $surname WHERE runner_id = $runner_id";
		$result = mysqli_query($conn, $sql) or die("Error updating record ".mysqli_error($conn));
		$numrows = mysqli_affected_rows($conn);
		
		echo("<input type=\"text\" id=\"firstname\" name=\"firstname\" class=\"form-control\"></td></tr><tr>");
		echo("<td>Surname: </td><td><input type=\"text\" id=\"surname\" name=\"surname\" class=\"form-control\"></td></tr>");
		echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
		echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
		echo("</br></div></td></tr></table></form>");
		
		$sql = "SELECT runner_id, first_name, surname FROM runner";
		echo("<br><table class=\"table table-bordered\"><tr><th>Name</th><th>Update</th><th>Delete</th><tr>");
		$result = mysqli_query($conn, $sql) or die("Error getting runner list");
		while ($row = mysqli_fetch_array($result)) 
		{
			echo("<tr><td>".$row["first_name"]." ".$row["surname"]."</td><td><a href=myrunner?trigger=2&runner=".$row["runner_id"]."&".SID.">Update</a></td><td><a href=myrunner?trigger=3&runner=".$row["runner_id"]."&".SID." onClick=\"return confirm('Delete This account?')\">Delete</a></td></tr>");
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