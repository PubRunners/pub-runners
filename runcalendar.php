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
			<div class ="col-md-10" id="pagemain" >
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
	 echo("</br><legend>Calendar of Running events </legend>");

	  //database connection
 include 'connection.php'; 
  // data functions
 include 'functions.php'; 
	

	
	$yearsql = "SELECT YEAR from (SELECT DISTINCT YEAR(event_date)as year from event) year_table WHERE YEAR >= YEAR(CURDATE()) order by YEAR desc";
	$result = mysqli_query($conn, $yearsql) or die("Error getting news list");
	while ($row = mysqli_fetch_array($result)) 
	{
	$year = $row["YEAR"];
	echo("<legend><b>".$year."</b></legend></br>");
	
        $monthsql = "SELECT MONTH, month_id from (SELECT DISTINCT MONTHNAME(event_date)as month,month(event_date) as month_id from event where year(event_date) = $year AND MONTH(event_date) >= MONTH(CURDATE())) month_table order by month_id";		
		$result2 = mysqli_query($conn, $monthsql) or die("Error getting news list");
			while ($row2 = mysqli_fetch_array($result2))
				{
				$month = $row2["MONTH"];
				echo("<legend>".$month."</legend></br>");
				
				$eventsql = "select event_name,date_format(event_date,'%d-%m-%Y') AS event_date,event_link, event_comments from event where year(event_date) = $year and monthname(event_date) = '$month' order by event_date ";
				$result3 = mysqli_query($conn, $eventsql) or die("Error getting news list");
				while ($row3 = mysqli_fetch_array($result3))
					{
					 $eventname = $row3["event_name"];
					 $eventdate = $row3["event_date"];
					 $eventlink = $row3["event_link"];
					 echo ("<table class=\"table table-bordered\">");
					 echo("<tr><td class=\"success\" width=\"25%\">Date</td><td>".$eventdate."</td></tr>");
					 echo("<tr><td class=\"success\" width=\"25%\">Event</td><td>".$eventname."</td></tr>");	
					 echo("<tr><td class=\"success\" width=\"25%\">Link</td><td><a href=\"".$eventlink."\" target=\"_blank\">".$eventlink."</a></td></tr>");		
					 echo ("</table>");	
					 
					 
					 
					}
	
				}
	}
	echo("</table>");
?>
</div>
<div class="span4">
			</div>
	</div> 
	</div>
</div>
</div>
				<?PHP
				include 'copyright.php';
				?>	
	</div>
</div>


</body>
</html>