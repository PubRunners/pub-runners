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
		<div class ="row" >
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
						</div>
						<div class="col-md-10"> <!--main panel -->
<?php
	 echo("</br>");

	  //database connection
 include 'connection.php'; 
  // data functions
 include 'functions.php'; 
	
	echo("<legend>Pub Runners Contact Details</Legend>");
	
	
	$sql = "SELECT contact_id,contact_name, contact_no, contact_email,active_flag FROM contact WHERE active_flag = 'Y'";
$result = mysqli_query($conn, $sql) or die("Error getting runner list");
while ($row = mysqli_fetch_array($result)) 
	{
	
		$contactname = $row["contact_name"];
		$contactemail = $row["contact_email"];
		$contactno = $row["contact_no"];
	
	
		echo ("<table class=\"table table-bordered\">");
		echo("<tr><td class=\"success\">Name</td><td>$contactname</td></tr>");	
		echo("<tr><td class=\"success\">Email</td><td><a href=\"mailto:".$contactemail."?Subject=PubRunner%20Enquiry\">".$contactemail."</a></td></tr>");	
		echo("<tr><td class=\"success\">Phone</td><td>".$contactno."</td></tr>");	
		echo ("</table>");	
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