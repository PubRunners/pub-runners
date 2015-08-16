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
				<br>
			<div class="row">
			<?PHP
			
			 //database connection
 include 'connection.php'; 
  // data functions
 include 'functions.php'; 
					
			$imagesql = "SELECT page_id, heading, text, image_position1, image_position2, image_position3 FROM front_page ";
			$result = mysqli_query($conn, $imagesql) or die("Error getting track list");
			$row = mysqli_fetch_array($result);
			$text = $row["text"];
			$photoposition1 = $row["image_position1"];
			$photoposition2 = $row["image_position2"];
			$photoposition3 = $row["image_position3"];
			$heading = $row["heading"];
			
			//photo row
			echo("<div class=\"col-md-4\">");
			echo("<img src=\"$photoposition1\" alt=\"$photoposition1\"  height=\"100%\" width=\"100%\" class=\"img-responsive img-rounded\">");
			echo("</div>");
			
			echo("<div class=\"col-md-4\">");
			echo("<img src=\"$photoposition2\" alt=\"$photoposition2\"  height=\"100%\" width=\"100%\" class=\"img-responsive img-rounded\">");
			echo("</div>");
			
			echo("<div class=\"col-md-4\">");
			echo("<img src=\"$photoposition3\" alt=\"$photoposition3\"  height=\"100%\" width=\"100%\" class=\"img-responsive img-rounded\">");
			echo("</div>");
			
			echo(" </div>");
			//new row
			echo("<div class=\"row\">");

			// 2 / 3rds text area
			echo("<div class=\"col-md-8\">");
			echo("<h2>$heading</h2>");
			echo("<p>$text</p>");
			echo(" </div>");
			
			// news item
			echo("<div class=\"col-md-4\">");
			echo("<br/>");
			$newsSQL = "select item_date,item_title,item_body, item_author from news_item where news_item_id = (select max(news_item_id)from news_item)";
			$newsresult = mysqli_query($conn, $newsSQL ) or die("Error getting news list");
			$newsrow = mysqli_fetch_array($newsresult);
			$date = $newsrow["item_date"];
			$title = $newsrow["item_title"];
			$body = $newsrow["item_body"];
			$author = $newsrow["item_author"];
			echo("<div class=\"well\">");
			echo("<h3 class=\"blog-post-title\">Latest News</h3>");
			echo("<p class=\"blog-post-meta\">".$date." by <a href=\"#\">".$author."</a></p>");
			echo("<p>$body</p>");
			echo("</div>");
			
			echo("</div>"); // news_item div

			echo(" </div>");//row 
			

	  echo("<hr><div class = \"row\">");
	  	  
	  	$tracksql = "SELECT track_name FROM track where pubrun_flag = 'Y' ";
		$result = mysqli_query($conn, $tracksql) or die("Error getting track list");
		while ($row = mysqli_fetch_array($result))
			{
				$trackname = $row["track_name"];
				echo("<div class=\"col-lg-2\">");
				echo("<a href =\"courses.php#$trackname\"><h1 class=\"text-center\"><small>$trackname</small></h1></a></div>");
			}
	  ?>

	  </div>
	  <hr>	  	
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