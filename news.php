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

 //database connection
 include 'connection.php'; 
  // data functions
 include 'functions.php'; 

	echo("<div class=\"col-md-2\">");
	echo("<br>");
	echo("<ul class=\"nav nav-list\">");

	$yearsql = "SELECT YEAR from (SELECT DISTINCT YEAR(item_date)as year from news_item) year_table order by YEAR desc";
	$result = mysqli_query($conn, $yearsql) or die("Error getting news list");
	while ($row = mysqli_fetch_array($result))
	{
	$year = $row["YEAR"];
	echo("<li class=\"nav-header\"><a href=\"news?#$year\">$year</a></li>");
	//echo("<h4><a href=\"#$year\">$year</a></h4>");
	//echo("<ol class=\"list-unstyled\">");
	$monthsql = "SELECT MONTH from (SELECT DISTINCT MONTHNAME(item_date)as month from news_item where year(item_date) = $year order by month(item_date)) month_table ";
			$result2 = mysqli_query($conn, $monthsql) or die("Error getting news list");
			while ($row2 = mysqli_fetch_array($result2))
				{
				$month = $row2["MONTH"];
				echo("<li><a href=\"news?#$month\">$month</a></li>");
				}
	}
	echo("</ul></div><div class=\"col-md-10\">");
	echo("<div class=\"container\">");
	echo("<div class=\"blog-header\">");	
	echo("<h1 class=\"blog-title\">Pubrunner News</h1>");
	echo("</div>");
    echo("<div class=\"row\">"); 
	echo("<div class=\"col-sm-8 blog-main\">");	

	
	$yearsql = "SELECT YEAR from (SELECT DISTINCT YEAR(item_date)as year from news_item) year_table order by YEAR desc";
	$result = mysqli_query($conn, $yearsql) or die("Error getting news list");
	while ($row = mysqli_fetch_array($result)) 
	{
		$year = $row["YEAR"];

		echo("<a name =\"$year\"></a>");
		$monthsql = "SELECT MONTH from (SELECT DISTINCT MONTHNAME(item_date)as month from news_item where year(item_date) = $year order by month(item_date) desc) month_table ";
			$result2 = mysqli_query($conn, $monthsql) or die("Error getting news list");
			while ($row2 = mysqli_fetch_array($result2))
				{
				$month = $row2["MONTH"];

				echo("<a name =\"$month\"></a>");
			
				$newsitemsql = "select date_format(item_date,'%d-%m-%Y') AS item_date,item_title,item_body, item_author from news_item where year(item_date) = $year and monthname(item_date) = '$month' order by item_date desc";

				$result3 = mysqli_query($conn, $newsitemsql) or die("Error getting news list");
				while ($row3 = mysqli_fetch_array($result3))
					{
					   $date = $row3["item_date"];
					   $title = $row3["item_title"];
					   $body = $row3["item_body"];
					   $author = $row3["item_author"];
					   
					
						
						echo("<div class=\"blog-post\">");
						echo("<hr>");
						echo("<h3 class=\"blog-post-title\">$title</h3>");
						echo("<p class=\"blog-post-meta\">".$date." by <a href=\"#\">".$author."</a></p>");
						echo("<p>$body</p>");
						echo("<hr>");
						echo("</div>");

					}
			
				}
	}
mysqli_close($conn);
?>
</div> <!-- col-sm-8 blog-main -->
</div> <!--row -->
</div> <!--container -->
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