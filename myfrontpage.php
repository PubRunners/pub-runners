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
<!--
<script>
	$(".texteditor").jqte();
</script>
-->
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
							echo("<a  onclick=\"document.getElementById('useradmin').submit();\">useradmin</a></li>");
	}
	echo("</ul></div><div class=\"col-md-10\">");




echo("</br><Legend>Homepage Administration</Legend><form action=\"myfrontpage\" method=\"get\">");
echo("<div class=\"form-group\">");
echo("<div class=\"well well-sm\"><h5>Image URL's</h5>");
echo("<table>");
	
     $trigger = $_GET["trigger"];
	
 //database connection
 include 'connection.php'; 
 
 // data functions
 include 'functions.php'; 

if ($trigger == 2) // update frontpage
{

$sql = "SELECT page_id,image_position1, image_position2,image_position3, heading, text FROM front_page WHERE page_id = (SELECT max(page_id) FROM front_page)";
$result = mysqli_query($conn,$sql) or die("error fetching row from runnerDb - ".mysql_error($conn));

if (mysqli_num_rows($result) == 0)die("Error – record not found to edit");
$row = mysqli_fetch_array($result);
$image1 = $row["image_position1"];
$image2 = $row["image_position2"];
$image3 = $row["image_position3"];
$heading = $row["heading"];
$text = $row["text"];
$pageid = $row["page_id"]; 

echo("<div class=\"form-group\">");
echo("<tr><td style=\"text-align:right\">Image 1:</td><td><input type=\"text\" id=\"image1\" class=\"form-control\" name=\"image1\" value=\"$image1\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Image 2:</td><td><input type=\"text\" id=\"image2\" class=\"form-control\" name=\"image2\" value=\"$image2\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Image 3:</td><td><input type=\"text\" id=\"image3\" class=\"form-control\" name=\"image3\" value=\"$image3\"></td></tr>");
echo("</table></div><br /><div class=\"well well-sm\"><table>");

echo("<tr><td style=\"text-align:right\">Heading:</td><td><input type=\"text\" id=\"heading\" class=\"form-control\" name=\"heading\" value=\"$heading\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Text: </td><td><textarea name=\"homepagetext\" class=\"texteditor\" rows=\"4\" cols=\"50\">$text</textarea></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=4></td><td></td></tr>");
echo("<input type=hidden name=pageid value=$pageid>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">UPDATE</button>");
echo("</div></div>");
echo("</br></div></td></tr></table></form>");

}

if ($trigger == 4) // do update
{


$image1 = escape($conn,$_GET["image1"]);
$image2 = escape($conn,$_GET["image2"]);
$image3 = escape($conn,$_GET["image3"]);
$heading = escape($conn,$_GET["heading"]);
$text = escape($conn,$_GET["homepagetext"]);
$pageid = $_GET["pageid"];



		$sql = "UPDATE front_page SET image_position1 = $image1,image_position2 = $image2, image_position3 = $image3, heading = $heading, text = $text WHERE page_id = $pageid";
		$result = mysqli_query($conn, $sql) or die("Error updating record ".mysqli_error($conn));
		$numrows = mysqli_affected_rows($conn);
		
		

$sql = "SELECT page_id,image_position1, image_position2,image_position3, heading, text FROM front_page WHERE page_id = (SELECT max(page_id) FROM front_page)";
$result = mysqli_query($conn,$sql) or die("error fetching row from runnerDb - ".mysql_error($conn));

if (mysqli_num_rows($result) == 0)die("Error – record not found to edit");
$row = mysqli_fetch_array($result);
$image1 = $row["image_position1"];
$image2 = $row["image_position2"];
$image3 = $row["image_position3"];
$heading = $row["heading"];
$text = $row["text"];
$pageid = $row["page_id"]; 

echo("<div class=\"form-group\">");
echo("<tr><td style=\"text-align:right\">Image 1:</td><td><input type=\"text\" id=\"image1\" class=\"form-control\" name=\"image1\" value=\"$image1\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Image 2:</td><td><input type=\"text\" id=\"image2\" class=\"form-control\" name=\"image2\" value=\"$image2\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Image 3:</td><td><input type=\"text\" id=\"image3\" class=\"form-control\" name=\"image3\" value=\"$image3\"></td></tr>");
echo("</table></div><br /><div class=\"well well-sm\"><table>");

echo("<tr><td style=\"text-align:right\">Heading:</td><td><input type=\"text\" id=\"heading\" class=\"form-control\" name=\"heading\" value=\"$heading\"></td></tr>");
echo("<tr><td style=\"text-align:right\">Text: </td><td><textarea name=\"homepagetext\" class=\"texteditor\" rows=\"4\" cols=\"50\">$text</textarea></td></tr>");
echo("<tr><td><input type=\"hidden\" name=\"trigger\" value=4></td><td></td></tr>");
echo("<input type=hidden name=pageid value=$pageid>");
echo("<tr><td></td><td><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">UPDATE</button>");
echo("</div></div>");
echo("</br></div></td></tr></table></form>");



mysqli_close($conn);
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