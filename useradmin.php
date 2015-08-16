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
 //check correct roles to view page
 $role = $_SESSION['role'];
 if ($role == "SUPER")
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




echo("</br><Legend>User Administration</Legend><form action=\"useradmin\" method=\"post\"><table>");
	
     $trigger = $_POST["trigger"];
	
 //database connection
 include 'connection.php'; 
  // data functions
 include 'functions.php'; 

	
if ($trigger == 0) // just display insert plus current list
{
echo("<div class=\"form-group\">");
echo("<tr><td style=\"text-align:right\">Username: </td><td><input type=\"text\"  class=\"form-control\" id=\"username\" name=\"username\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Userid: </td><td><input type=\"text\"  class=\"form-control\" id=\"userid\" name=\"userid\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Password: </td><td><input type=\"password\" class=\"form-control\" id=\"password\" name=\"password\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Confirm Password: </td><td><input type=\"password\" class=\"form-control\" id=\"confirm\" name=\"confirm\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Active Flag: </td><td><select  class=\"form-control\" id=\"activeflag\" name=\"activeflag\"><option value=\" \"> </option><option value=\"Y\">Yes</option><option value=\"N\">No</option></select></td></tr>");
echo("<tr><td style=\"text-align:right\">Role: </td><td><select class=\"form-control\" name=\"role\" id=\"role\">
						<option value=\"USER\">Basic User</option>
						<option value=\"ADMIN\">Administrator</option>
						<option value=\"SUPER\">Super User</option>
						</select></td></tr>");	
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</div>");
echo("</br></div></td></tr></table></form>");

$sql = "SELECT id, user_name , userid, active_flag, user_role, created_date FROM user";

echo("<table class=\"table table-bordered\"><tr><th>user name</th><th>userid</th><th>active</th><th>role</th><th>date</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting track list");
while ($row = mysqli_fetch_array($result)) 
	{
	$id = $row["id"];
	//update form for post method
	$update = "update".$id;

	echo("<form id=\"$update\" method=\"post\" action=\"useradmin?".SID."\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"2\" /> ");
	echo("<input type=\"hidden\" name=\"id\" value=\"$id\" /> ");
	echo("</form>");	;
    
	
	//delete form for post method
    $delete = "delete".$id;
	
	echo("<form id=\"$delete\" method=\"post\" action=\"useradmin?".SID."\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"3\" /> ");
	echo("<input type=\"hidden\" name=\"id\" value=\"$id\" /> ");
	echo("</form>");
		
		
		
		echo("<tr><td>".$row["user_name"]."</td><td>".$row["userid"]."</td><td>".$row["active_flag"]."</td><td>".$row["user_role"]."</td><td>".$row["created_date"]."</td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$update').submit();\">UPDATE</button></td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$delete').submit();\">DELETE</button></td></tr>");
	}
echo("</table>");
	 
}	 
if ($trigger == 1) //insert a user
{



		// make sure all fields are input
		if ((!isSet($_POST["username"]))||
		(!isSet($_POST["userid"]))||
		(!isSet($_POST["password"]))||
		(!isSet($_POST["confirm"]))||
		(!isSet($_POST["activeflag"]))||
		(!isSet($_POST["role"])))
		die("All Fields are Mandatory");
		
		
		//get all fields
		$username = escape($conn,$_POST["username"]);
		$userid = escape($conn,$_POST["userid"]);
		$password = escape($conn,$_POST["password"]);
		$confirm = escape($conn,$_POST["confirm"]);
		$activeflag = escape($conn,$_POST["activeflag"]);
		$role = escape($conn,$_POST["role"]);
		
		//make sure password matches
		IF ($password != $confirm)
			die ("Password is not re confirmed");
		
		$username = strtoupper($username);
		$userid = strtoupper($userid);
		
		//check for duplicate users
		$checkSQL = "SELECT COUNT(userid) as count FROM user WHERE (UPPER(userid) = $userid) AND (UPPER(user_name) = $username)"; 
		$result = mysqli_query($conn,$checkSQL) or die ("Error checking for duplicates - ".mysqli_error($conn));
		while ($row1 = mysqli_fetch_array($result)) 
		{
		$count = $row1["count"];
		}
		if ($count > 0)
			die ("user already exists");
		
		$insertSQL = "INSERT INTO user(user_name,userid,password,active_flag,user_role,created_date) VALUES ($username,$userid,SHA($password),$activeflag,$role,CURDATE())";
		$result = mysqli_query($conn,$insertSQL) or die ("Error inserting user - ".mysqli_error($conn));
		
		if (mysqli_affected_rows($conn) != 1) 
		die("Error inserting user");
		
echo("<div class=\"form-group\">");
echo("<tr><td style=\"text-align:right\">Username: </td><td><input type=\"text\"  class=\"form-control\" id=\"username\" name=\"username\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Userid: </td><td><input type=\"text\"  class=\"form-control\" id=\"userid\" name=\"userid\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Password: </td><td><input type=\"password\" class=\"form-control\" id=\"password\" name=\"password\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Confirm Password: </td><td><input type=\"password\" class=\"form-control\" id=\"confirm\" name=\"confirm\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Active Flag: </td><td><select  class=\"form-control\" id=\"activeflag\" name=\"activeflag\"><option value=\" \"> </option><option value=\"Y\">Yes</option><option value=\"N\">No</option></select></td></tr>");
echo("<tr><td style=\"text-align:right\">Role: </td><td><select class=\"form-control\" id=\"role\" name=\"role\">
						<option value=\"USER\">Basic User</option>
						<option value=\"ADMIN\">Administrator</option>
						<option value=\"SUPER\">Super User</option>
						</select></td></tr>");	
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</div>");
echo("</br></div></td></tr></table></form>");

$sql = "SELECT id, user_name , userid, active_flag, user_role, created_date FROM user";

echo("<table class=\"table table-bordered\"><tr><th>user name</th><th>userid</th><th>active</th><th>role</th><th>date</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting track list");
while ($row = mysqli_fetch_array($result)) 
	{
		$id = $row["id"];
	//update form for post method
	$update = "update".$id;

	echo("<form id=\"$update\" method=\"post\" action=\"useradmin?".SID."\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"2\" /> ");
	echo("<input type=\"hidden\" name=\"id\" value=\"$id\" /> ");
	echo("</form>");	;
    
	
	//delete form for post method
    $delete = "delete".$id;

	echo("<form id=\"$delete\" method=\"post\" action=\"useradmin?".SID."\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"3\" /> ");
	echo("<input type=\"hidden\" name=\"id\" value=\"$id\" /> ");
	echo("</form>");
		
		
		echo("<tr><td>".$row["user_name"]."</td><td>".$row["userid"]."</td><td>".$row["active_flag"]."</td><td>".$row["user_role"]."</td><td>".$row["created_date"]."</td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$update').submit();\">UPDATE</button></td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$delete').submit();\">DELETE</button></td></tr>");
	}
echo("</table>");
}

if ($trigger == 2) // update a user
{
if (!isset($_POST["id"]))
	die("You need to select a track from the form");
$id = $_POST["id"];

$sql = "SELECT user_name,userid,active_flag,user_role,created_date FROM user WHERE id = $id";
$result = mysqli_query($conn,$sql) or die("error fetching row from runnerDb - ".mysql_error($conn));

if (mysqli_num_rows($result) == 0)
				die("Error – record not found to edit");

while ($row = mysqli_fetch_array($result))
			{
					$username = $row["user_name"];
					$userid = $row["userid"];
					$activeflag = $row["active_flag"];
					$role = $row["user_role"];
			}
			
			
echo("<div class=\"form-group\">");
echo("<tr><td style=\"text-align:right\">Username: </td><td><input type=\"text\"  class=\"form-control\" id=\"username\" name=\"username\" value=\"$username\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Userid: </td><td><input type=\"text\"  class=\"form-control\" id=\"userid\" name=\"userid\" value=\"$userid\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Password: </td><td><input type=\"password\" class=\"form-control\" id=\"password\" name=\"password\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Confirm Password: </td><td><input type=\"password\" class=\"form-control\" id=\"confirm\" name=\"confirm\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Active Flag: </td><td><select  class=\"form-control\" id=\"activeflag\" name=\"activeflag\"><option value=\" \"></option>"); 

IF($activeflag == 'Y')
{
	echo("<option value=\"Y\" selected>Yes</option><option value=\"N\">No</option></select></td></tr>");
}
ELSE
{
	echo("<option value=\"Y\">Yes</option><option value=\"N\" selected>No</option></select></td></tr>");
}
if ($role == 'SUPER') 
{
echo("<tr><td style=\"text-align:right\">Role: </td><td><select class=\"form-control\" id=\"role\" name=\"role\">
						<option value=\"USER\">Basic User</option>
						<option value=\"ADMIN\">Administrator</option>
						<option value=\"SUPER\" selected>Super User</option>
						</select></td></tr>");	

} 
elseif ($role == 'ADMIN') 
{
    echo("<tr><td style=\"text-align:right\">Role: </td><td><select class=\"form-control\" id=\"role\" name=\"role\">
						<option value=\"USER\">Basic User</option>
						<option value=\"ADMIN\" selected>Administrator</option>
						<option value=\"SUPER\">Super User</option>
						</select></td></tr>");	

} 
else 
{
    echo("<tr><td style=\"text-align:right\">Role: </td><td><select class=\"form-control\" id=\"role\" name=\"role\">
						<option value=\"USER\" selected>Basic User</option>
						<option value=\"ADMIN\">Administrator</option>
						<option value=\"SUPER\">Super User</option>
						</select></td></tr>");	

}
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=4></td><td></td></tr>");
echo("<input type=hidden name=id value=$id >");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</div>");
echo("</br></div></td></tr></table></form>");

$sql = "SELECT id, user_name , userid, active_flag, user_role, created_date FROM user";

echo("<table class=\"table table-bordered\"><tr><th>user name</th><th>userid</th><th>active</th><th>role</th><th>date</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting track list");
while ($row = mysqli_fetch_array($result)) 
	{
		
		
		
		
				$id = $row["id"];
	//update form for post method
	$update = "update".$id;
	
	echo("<form id=\"$update\" method=\"post\" action=\"useradmin?".SID."\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"2\" /> ");
	echo("<input type=\"hidden\" name=\"id\" value=\"$id\" /> ");
	echo("</form>");	;
    
	
	//delete form for post method
    $delete = "delete".$id;
	
	echo("<form id=\"$delete\" method=\"post\" action=\"useradmin?".SID."\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"3\" /> ");
	echo("<input type=\"hidden\" name=\"id\" value=\"$id\" /> ");
	echo("</form>");
		
		
		echo("<tr><td>".$row["user_name"]."</td><td>".$row["userid"]."</td><td>".$row["active_flag"]."</td><td>".$row["user_role"]."</td><td>".$row["created_date"]."</td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$update').submit();\">UPDATE</button></td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$delete').submit();\">DELETE</button></td></tr>");
	}
echo("</table>");
}

if ($trigger == 3) // delete a track
{

echo("<div class=\"form-group\">");
echo("<tr><td style=\"text-align:right\">Username: </td><td><input type=\"text\"  class=\"form-control\" id=\"username\" name=\"username\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Userid: </td><td><input type=\"text\"  class=\"form-control\" id=\"userid\" name=\"userid\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Password: </td><td><input type=\"password\" class=\"form-control\" id=\"password\" name=\"password\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Confirm Password: </td><td><input type=\"password\" class=\"form-control\" id=\"confirm\" name=\"confirm\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Active Flag: </td><td><select  class=\"form-control\" id=\"activeflag\" name=\"activeflag\"><option value=\" \"> </option><option value=\"Y\">Yes</option><option value=\"N\">No</option></select></td></tr>");
echo("<tr><td style=\"text-align:right\">Role: </td><td><select class=\"form-control\" id=\"role\" name=\"role\">
						<option value=\"USER\">Basic User</option>
						<option value=\"ADMIN\">Administrator</option>
						<option value=\"SUPER\">Super User</option>
						</select></td></tr>");	
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</div>");
echo("</br></div></td></tr></table></form>");

if (!isset($_POST["id"]))
	die("You need to select a user from the form");
$id = $_POST["id"];

$sql = "DELETE FROM user WHERE id = $id ";
$result = mysqli_query($conn, $sql) or die("Error deleting record ".mysqli_error($conn));
	$numrows = mysqli_affected_rows($conn);
	if ($numrows == 1)
	{
		
$sql = "SELECT id, user_name , userid, active_flag, user_role, created_date FROM user";

echo("<table class=\"table table-bordered\"><tr><th>user name</th><th>userid</th><th>active</th><th>role</th><th>date</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting track list");
while ($row = mysqli_fetch_array($result)) 
	{
				$id = $row["id"];
	//update form for post method
	$update = "update".$id;
	
	echo("<form id=\"$update\" method=\"post\" action=\"useradmin?".SID."\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"2\" /> ");
	echo("<input type=\"hidden\" name=\"id\" value=\"$id\" /> ");
	echo("</form>");	;
    
	
	//delete form for post method
    $delete = "delete".$id;
	
	echo("<form id=\"$delete\" method=\"post\" action=\"useradmin?".SID."\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"3\" /> ");
	echo("<input type=\"hidden\" name=\"id\" value=\"$id\" /> ");
	echo("</form>");
		
		
		echo("<tr><td>".$row["user_name"]."</td><td>".$row["userid"]."</td><td>".$row["active_flag"]."</td><td>".$row["user_role"]."</td><td>".$row["created_date"]."</td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$update').submit();\">UPDATE</button></td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$delete').submit();\">DELETE</button></td></tr>");
	}
echo("</table>");
		
	}
	else
	{
		echo "<p class=\"pageheading\">Delete NOT Successful</p>"; 
		$sql = "SELECT id, user_name , userid, active_flag, user_role, created_date FROM user";

		echo("<table class=\"table table-bordered\"><tr><th>user name</th><th>userid</th><th>active</th><th>role</th><th>date</th><th>Update</th><th>Delete</th><tr>");
		$result = mysqli_query($conn, $sql) or die("Error getting track list");
		while ($row = mysqli_fetch_array($result)) 
			{
						$id = $row["id"];
	//update form for post method
	$update = "update".$id;
	
	echo("<form id=\"$update\" method=\"post\" action=\"useradmin?".SID."\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"2\" /> ");
	echo("<input type=\"hidden\" name=\"id\" value=\"$id\" /> ");
	echo("</form>");	;
    
	
	//delete form for post method
    $delete = "delete".$id;
		
	echo("<form id=\"$delete\" method=\"post\" action=\"useradmin?".SID."\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"3\" /> ");
	echo("<input type=\"hidden\" name=\"id\" value=\"$id\" /> ");
	echo("</form>");
		
		
		echo("<tr><td>".$row["user_name"]."</td><td>".$row["userid"]."</td><td>".$row["active_flag"]."</td><td>".$row["user_role"]."</td><td>".$row["created_date"]."</td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$update').submit();\">UPDATE</button></td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$delete').submit();\">DELETE</button></td></tr>");
			}
		echo("</table>");
		}
}

if ($trigger == 4) // do update
{
		if ((!isSet($_POST["username"]))||
		(!isSet($_POST["userid"]))||
		(!isSet($_POST["activeflag"]))||
		(!isSet($_POST["role"])))
		die("Fields cannot be blank except for password fields");
		
		//get all fields
		$username = escape($conn,$_POST["username"]);
		$userid = escape($conn,$_POST["userid"]);
		$activeflag = escape($conn,$_POST["activeflag"]);
		$role = escape($conn,$_POST["role"]);
		$id = escape($conn,$_POST["id"]);
		
		$userid = strtoupper($userid);
		
		IF((!isSet($_POST["password"]))||
		(!isSet($_POST["confirm"])))
		{
			$password = escape($conn,$_POST["password"]);
			$confirm = escape($conn,$_POST["confirm"]);
		
		//make sure password matches
			IF ($password != $confirm)
				die ("Password is not re confirmed");
		
			// do update including password
			$sql = "UPDATE user SET user_name = $username,userid = $userid, password = SHA($password), user_role = $role,active_flag = $activeflag  WHERE id = $id";
			$result = mysqli_query($conn, $sql) or die("Error updating record ".mysqli_error($conn));
			$numrows = mysqli_affected_rows($conn);
		}
		ELSE //no password set
		{
			// do update excluding password
			$sql = "UPDATE user SET user_name = $username,userid = $userid, user_role = $role,active_flag = $activeflag  WHERE id = $id";
			$result = mysqli_query($conn, $sql) or die("Error updating record ".mysqli_error($conn));
			$numrows = mysqli_affected_rows($conn);
		}

echo("<div class=\"form-group\">");
echo("<tr><td style=\"text-align:right\">Username: </td><td><input type=\"text\"  class=\"form-control\" id=\"username\" name=\"username\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Userid: </td><td><input type=\"text\"  class=\"form-control\" id=\"userid\" name=\"userid\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Password: </td><td><input type=\"password\" class=\"form-control\" id=\"password\" name=\"password\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Confirm Password: </td><td><input type=\"password\" class=\"form-control\" id=\"confirm\" name=\"confirm\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Active Flag: </td><td><select  class=\"form-control\" id=\"activeflag\" name=\"activeflag\"><option value=\" \"> </option><option value=\"Y\">Yes</option><option value=\"N\">No</option></select></td></tr>");
echo("<tr><td style=\"text-align:right\">Role: </td><td><select class=\"form-control\" id=\"role\" name=\"role\">
						<option value=\"USER\">Basic User</option>
						<option value=\"ADMIN\">Administrator</option>
						<option value=\"SUPER\">Super User</option>
						</select></td></tr>");	
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=1></td><td></td></tr>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button>");
echo("</div>");
echo("</br></div></td></tr></table></form>");		

		
$sql = "SELECT id, user_name , userid, active_flag, user_role, created_date FROM user";

echo("<table class=\"table table-bordered\"><tr><th>user name</th><th>userid</th><th>active</th><th>role</th><th>date</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting track list");
while ($row = mysqli_fetch_array($result)) 
	{
				$id = $row["id"];
	//update form for post method
	$update = "update".$id;
	
	echo("<form id=\"$update\" method=\"post\" action=\"useradmin?".SID."\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"2\" /> ");
	echo("<input type=\"hidden\" name=\"id\" value=\"$id\" /> ");
	echo("</form>");	;
    
	
	//delete form for post method
    $delete = "delete".$id;
		
	echo("<form id=\"$delete\" method=\"post\" action=\"useradmin?".SID."\">");
	echo("<input type=\"hidden\" name=\"trigger\" value=\"3\" /> ");
	echo("<input type=\"hidden\" name=\"id\" value=\"$id\" /> ");
	echo("</form>");
		
		
		echo("<tr><td>".$row["user_name"]."</td><td>".$row["userid"]."</td><td>".$row["active_flag"]."</td><td>".$row["user_role"]."</td><td>".$row["created_date"]."</td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$update').submit();\">UPDATE</button></td><td><button class=\"btn btn-primary\" onclick=\"document.getElementById('$delete').submit();\">DELETE</button></td></tr>");
	}
echo("</table>");
}
mysqli_close($conn);
}
else
{
echo "You have insufficient privileges to view this page";
}

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