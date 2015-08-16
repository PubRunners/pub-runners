<!DOCTYPE>
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
			<div class ="col-md-10" id="pagemain" style="height:100%;">
				<?PHP
				include 'title.php';
				?>	
				<div class="row">
					<div class="col-md-12" id="cssmenu">
						<ul> 
						<li><a href='logout'><span>logout</span></a></li>
						<li><a href='contact'><span>Contact</span></a></li> 
						<li ><a href='runcalendar'><span>Events</span></a></li>
						<li><a href='news'><span>News</span></a></li>
						<li class='has-sub'><a href='resulthistory'><span>Results</span></a></li>
					</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
					<div class = "row">
					<?php
 //database connection
 include 'connection.php'; 
 include 'functions.php';

							
									if ((!isSet($_POST["userid"])) ||
									(!isSet($_POST["password"])))
									die("You must input both a user name and password. Return to <a href=\"login\">Login</a>");
							
				
						
						$userid = escape($conn,$_POST["userid"]);
						$password = escape($conn,$_POST["password"]);
						//$password = $_POST["password"];
						$userid = strtoupper($userid);
							
						$sql = "SELECT id,userid,user_role,user_name FROM user WHERE (userid=$userid) AND (password = SHA($password))";
						$result = mysqli_query($conn, $sql) or die("Error checking password - ".mysqli_error($conn));
						$numrows = mysqli_num_rows($result); 
						
						//there should be exactly one row with the correct id and password
						if ($numrows == 1)
						{
                        //get the username
							$row = mysqli_fetch_array($result);
							$username = $row['userid'];
							$role = $row['user_role'];
							$name = $row['user_name'];

							session_name('runneradmin'); 
							session_start();                
							$_SESSION['authenticated'] = 'Y';
							$_SESSION['role'] = $role;
							$_SESSION['name'] = $name;
							
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
							echo "<h1>Welcome $name</h1>";
							echo "<h2>You have successfully logged in</h2>";
						
						echo("</div>");
							
							
							
							
					mysqli_close($conn);		
                }
                else
                {
                        echo 'The id or password was incorrect';
                }


						
							
					
					
					?>
				</div>
			</div>
		</div>
<div class ="col-md-1">
</div>

</div>
</div>
				<?PHP
				include 'copyright.php';
				?>	
</body>
</html>