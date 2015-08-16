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
<body style = "background: linear-gradient(#E3E3FF, #FFFFFF);">
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
				<br>
				<?php
				
				 //database connection
				include 'connection.php'; 
				// data functions
				include 'functions.php'; 
				
				$tracksql = "SELECT track_id,track_name,track_length,track_link, track_description,track_photo FROM track where pubrun_flag = 'Y' ";
				$result = mysqli_query($conn, $tracksql) or die("Error getting track list");
				while ($row = mysqli_fetch_array($result))
				{
				$trackname = $row["track_name"];
				$length = $row["track_length"];
				$link = $row["track_link"];
				$description = $row["track_description"];
				$photo =  $row["track_photo"];
				
				echo("<div class=\"row\">");
				echo("<div class=\"col-md-6\">");
				echo("<img src=\"$photo\" alt=\"$trackname\" width=\"100%\" height=\"100%\" class=\"img-responsive img-rounded\">");
				echo("</div>");
				echo("<div class=\"col-md-6\">");
				echo("<a  name=\"$trackname\"></a>");
				echo("<a href=\"$link\"><h2>$trackname</h2></a>");
				echo("<h3>$length KM</h3>");
				echo("<p>$description</p>");
				echo("</div>");
				echo("</div>");
				echo("<hr>");
				}
				?>  	
</div>
</div>
</div>
<div class ="col-md-1">
</div>
				<?PHP
				include 'copyright.php';
				?>	
</div>
</div>
</body>
</html>