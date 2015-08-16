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
	
	
	
	
	echo("<h3>Manage Website Contact Details</h3>");
	echo("<form action=\"mycontacts\" method=\"get\">");
     $trigger = $_GET["trigger"];
	 
  //database connection
 include 'connection.php'; 
  // data functions
 include 'functions.php';

	
if ($trigger == 0) // just display insert plus current list
{


echo("<table><tr>");				
echo("<td>Name: </td><td><input type=\"text\" id=\"contactname\" name=\"contactname\" class=\"form-control\"></td></tr>");
echo("<tr><td>Email: </td><td><input type=\"text\" id=\"contactemail\" name=\"contactemail\" class=\"form-control\"></td></tr>");
echo("<tr><td>Number: </td><td><input type=\"text\" id=\"contactno\" name=\"contactno\" class=\"form-control\"></td></tr>");
echo("<tr><td>Active Flag: </td><td><select id=\"activeflag\" name=\"activeflag\" class=\"form-control\"><option value=\" \"> </option><option value=\"Y\">Yes</option><option value=\"N\">No</option></select></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");

echo("</br></div></td></tr></table></form>");

$sql = "SELECT contact_id,contact_name, contact_no, contact_email,active_flag FROM contact";
echo("<br><table class=\"table table-bordered\"><tr><th>Name</th><th>Email</th><th>Number</th><th>Active?</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting runner list");
while ($row = mysqli_fetch_array($result)) 
	{
	$flag = $row["active_flag"];

	if ($flag == "Y")
	{

	$flag = "Yes";
	}
	else
	{

	$flag = "No";
	}
		echo("<tr><td>".$row["contact_name"]."</td><td>".$row["contact_email"]."</td><td>".$row["contact_no"]."</td><td>".$flag."</td><td><a href=mycontacts?trigger=2&contact=".$row["contact_id"]."&".SID.">Update</a></td><td><a href=mycontacts?trigger=3&contact=".$row["contact_id"]."&".SID." onClick=\"return confirm('Delete This contact?')\">Delete</a></td></tr>");
	}
echo("</table>");
	 
}
	 
if ($trigger == 1) //insert a contact
{

echo("<table><tr>");				
echo("<td>Name: </td><td><input type=\"text\" id=\"contactname\" name=\"contactname\" class=\"form-control\"></td></tr>");
echo("<tr><td>Email: </td><td><input type=\"text\" id=\"contactemail\" name=\"contactemail\" class=\"form-control\"></td></tr>");
echo("<tr><td>Number: </td><td><input type=\"text\" id=\"contactno\" name=\"contactno\" class=\"form-control\"></td></tr>");
echo("<tr><td>Active Flag: </td><td><select id=\"activeflag\" name=\"activeflag\" class=\"form-control\"><option value=\" \"> </option><option value=\"Y\">Yes</option><option value=\"N\">No</option></select></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");

echo("</br></div></td></tr></table></form>");

		if ((!isSet($_GET["contactname"])) ||
		(!isSet($_GET["contactemail"])))
		die("You must input both a name and email at least");
		
		$contactname = escape($conn,$_GET["contactname"]);
		$contactemail = escape($conn,$_GET["contactemail"]);
		$contactno = escape($conn,$_GET["contactno"]);
		$activeflag = $_GET["activeflag"];
		
		
		$sql = "INSERT INTO contact(contact_name, contact_no, contact_email,active_flag) VALUES ($contactname,$contactno,$contactemail,'$activeflag')";
		$result = mysqli_query($conn,$sql) or die ("Error inserting record - ".mysqli_error($conn));
		
		if (mysqli_affected_rows($conn) != 1) 
		die("Error inserting contact");

$sql = "SELECT contact_id,contact_name, contact_no, contact_email,active_flag FROM contact";
echo("<br><table class=\"table table-bordered\"><tr><th>Name</th><th>Email</th><th>Number</th><th>Active?</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting runner list");
while ($row = mysqli_fetch_array($result)) 
	{
	$flag = $row["active_flag"];
	if ($flag == "Y")
	{
	$flag = "Yes";
	}
	else
	{
	$flag = "No";
	}
		echo("<tr><td>".$row["contact_name"]."</td><td>".$row["contact_email"]."</td><td>".$row["contact_no"]."</td><td>".$flag."</td><td><a href=mycontacts?trigger=2&contact=".$row["contact_id"]."&".SID.">Update</a></td><td><a href=mycontacts?trigger=3&contact=".$row["contact_id"]."&".SID." onClick=\"return confirm('Delete This contact?')\">Delete</a></td></tr>");
	}
echo("</table>");
}

if ($trigger == 2)
{
if (!isset($_GET["contact"]))
	die("You need to select a contact from the form1");
$contact_id = $_GET["contact"];

$sql = "SELECT contact_id,contact_name, contact_no, contact_email,active_flag FROM contact WHERE contact_id = $contact_id";
$result = mysqli_query($conn,$sql) or die("error fetching row from runnerDb - ".mysql_error($conn));

if (mysqli_num_rows($result) == 0)
				die("Error – record not found to edit");

while ($row = mysqli_fetch_array($result))
			{
		$contactname = $row["contact_name"];
		$contactemail = $row["contact_email"];
		$contactno = $row["contact_no"];
		$activeflag = $row["active_flag"];
			}
			
echo("<table><tr>");				
echo("<td>Name: </td><td><input type=\"text\" id=\"contactname\" name=\"contactname\" value=\"$contactname\" class=\"form-control\"></td></tr>");
echo("<tr><td>Email: </td><td><input type=\"text\" id=\"contactemail\" name=\"contactemail\" value=\"$contactemail\" class=\"form-control\"></td></tr>");
echo("<tr><td>Number: </td><td><input type=\"text\" id=\"contactno\" name=\"contactno\" value=\"$contactno\" class=\"form-control\"></td></tr>");
echo("<tr><td>Active Flag: </td><td><select id=\"activeflag\" name=\"activeflag\" class=\"form-control\"><option value=\" \"> </option><option value=\"Y\">Yes</option><option value=\"N\">No</option></select></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=4></td><td></td></tr>");
echo("<input type=hidden name=contact value=$contact_id >");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</br></div></td></tr></table></form>");

$sql = "SELECT contact_id,contact_name, contact_no, contact_email,active_flag FROM contact";
echo("<br><table class=\"table table-bordered\"><tr><th>Name</th><th>Email</th><th>Number</th><th>Active?</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting runner list");
while ($row = mysqli_fetch_array($result)) 
	{
	$flag = $row["active_flag"];

	if ($flag == "Y")
	{

	$flag = "Yes";
	}
	else
	{

	$flag = "No";
	}
		echo("<tr><td>".$row["contact_name"]."</td><td>".$row["contact_email"]."</td><td>".$row["contact_no"]."</td><td>".$flag."</td><td><a href=mycontacts?trigger=2&contact=".$row["contact_id"]."&".SID.">Update</a></td><td><a href=mycontacts?trigger=3&contact=".$row["contact_id"]."&".SID." onClick=\"return confirm('Delete This contact?')\">Delete</a></td></tr>");
	}
echo("</table>");
}

if ($trigger == 3) // delete a contact
{

echo("<table><tr>");				
echo("<td>Name: </td><td><input type=\"text\" id=\"contactname\" name=\"contactname\" class=\"form-control\"></td></tr>");
echo("<tr><td>Email: </td><td><input type=\"text\" id=\"contactemail\" name=\"contactemail\" class=\"form-control\"></td></tr>");
echo("<tr><td>Number: </td><td><input type=\"text\" id=\"contactno\" name=\"contactno\" class=\"form-control\"></td></tr>");
echo("<tr><td>Active Flag: </td><td><select id=\"activeflag\" name=\"activeflag\" class=\"form-control\"><option value=\" \"> </option><option value=\"Y\">Yes</option><option value=\"N\">No</option></select></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");

echo("</br></div></td></tr></table></form>");

if (!isset($_GET["contact"]))
	die("You need to select a contact from the form2");
$contact_id = $_GET["contact"];

$sql = "DELETE FROM contact WHERE contact_id = $contact_id";
$result = mysqli_query($conn, $sql) or die("Error deleting record ".mysqli_error($conn));
$numrows = mysqli_affected_rows($conn);
	if ($numrows == 1)
	{
$sql = "SELECT contact_id,contact_name, contact_no, contact_email,active_flag FROM contact";
echo("<br><table class=\"table table-bordered\"><tr><th>Name</th><th>Email</th><th>Number</th><th>Active?</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting runner list");
while ($row = mysqli_fetch_array($result)) 
	{
	$flag = $row["active_flag"];

	if ($flag == "Y")
	{

	$flag = "Yes";
	}
	else
	{
	$flag = "No";
	}
		echo("<tr><td>".$row["contact_name"]."</td><td>".$row["contact_email"]."</td><td>".$row["contact_no"]."</td><td>".$flag."</td><td><a href=mycontacts?trigger=2&contact=".$row["contact_id"]."&".SID.">Update</a></td><td><a href=mycontacts?trigger=3&contact=".$row["contact_id"]."&".SID." onClick=\"return confirm('Delete This contact?')\">Delete</a></td></tr>");
	}
echo("</table>");
		
	}
	else
	{
		echo "<p class=\"pageheading\">Delete NOT Successfull</p>"; 
$sql = "SELECT contact_id,contact_name, contact_no, contact_email,active_flag FROM contact";
echo("<br><table class=\"table table-bordered\"><tr><th>Name</th><th>Email</th><th>Number</th><th>Active?</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting runner list");
while ($row = mysqli_fetch_array($result)) 
	{
	$flag = $row["active_flag"];

	if ($flag == "Y")
	{

	$flag = "Yes";
	}
	else
	{

	$flag = "No";
	}
		echo("<tr><td>".$row["contact_name"]."</td><td>".$row["contact_email"]."</td><td>".$row["contact_no"]."</td><td>".$flag."</td><td><a href=mycontacts?trigger=2&contact=".$row["contact_id"]."&".SID.">Update</a></td><td><a href=mycontacts?trigger=3&contact=".$row["contact_id"]."&".SID." onClick=\"return confirm('Delete This contact?')\">Delete</a></td></tr>");
	}
echo("</table>");
	}
}

if ($trigger == 4) // do update
{



		if ((!isSet($_GET["contactname"])) ||
		(!isSet($_GET["contactemail"])))
		die("You must input both a name and email at least");
		
		$contactname = escape($conn,$_GET["contactname"]);
		$contactemail = escape($conn,$_GET["contactemail"]);
		$contactno = escape($conn,$_GET["contactno"]);
		$activeflag = $_GET["activeflag"];
		$contact_id = $_GET["contact"];
		
		$sql = "UPDATE contact SET contact_name = $contactname,contact_email = $contactemail, contact_no = $contactno, active_flag = '$activeflag' WHERE contact_id = $contact_id";
		$result = mysqli_query($conn, $sql) or die("Error updating record ".mysqli_error($conn));
		$numrows = mysqli_affected_rows($conn);
		
echo("<table><tr>");				
echo("<td>Name: </td><td><input type=\"text\" id=\"contactname\" name=\"contactname\" class=\"form-control\"></td></tr>");
echo("<tr><td>Email: </td><td><input type=\"text\" id=\"contactemail\" name=\"contactemail\" class=\"form-control\"></td></tr>");
echo("<tr><td>Number: </td><td><input type=\"text\" id=\"contactno\" name=\"contactno\" class=\"form-control\"></td></tr>");
echo("<tr><td>Active Flag: </td><td><select id=\"activeflag\" name=\"activeflag\" class=\"form-control\"><option value=\" \"> </option><option value=\"Y\">Yes</option><option value=\"N\">No</option></select></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</br></div></td></tr></table></form>");
		
$sql = "SELECT contact_id,contact_name, contact_no, contact_email,active_flag FROM contact";
echo("<br><table class=\"table table-bordered\"><tr><th>Name</th><th>Email</th><th>Number</th><th>Active?</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting runner list");
while ($row = mysqli_fetch_array($result)) 
	{
	$flag = $row["active_flag"];

	if ($flag == "Y")
	{

	$flag = "Yes";
	}
	else
	{

	$flag = "No";
	}
		echo("<tr><td>".$row["contact_name"]."</td><td>".$row["contact_email"]."</td><td>".$row["contact_no"]."</td><td>".$flag."</td><td><a href=mycontacts?trigger=2&contact=".$row["contact_id"]."&".SID.">Update</a></td><td><a href=mycontacts?trigger=3&runner=".$row["contact_id"]."&".SID." onClick=\"return confirm('Delete This contact?')\">Delete</a></td></tr>");
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