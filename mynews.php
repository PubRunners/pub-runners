<!DOCTYPE>
<?PHP
session_name('runneradmin');	
session_start();
?>
<html>
<head>
<base href="/" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">	
<link rel="stylesheet" type="text/css" href="css/crimsonrunner.css">
<link rel="stylesheet" type="text/css" href="css/menus.css">
<link rel="stylesheet" type="text/css" href="css/jquery-te-1.4.0.css">

<script type="text/javascript" charset="utf-8" src="/DataTables/media/js/jquery.js"></script>
<script type="text/javascript" charset="utf-8" src="/DataTables/media/js/jquery-te-1.4.0.min.js"></script>

<script>
$(document).ready( function () {
    $(".texteditor").jqte();
} );
</script>
	<title>RunnerApp v0.3</title>	
</head>
<style type="text/css">
.texteditor{width:75%;}
</style>
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
							//echo("<li><a href=\"useradmin?trigger=0&".SID."\">useradmin</a></li>");
							echo("<a  onclick=\"document.getElementById('useradmin').submit();\">useradmin</a></li>");
							}
							echo("</ul></div><div class=\"col-md-10\">");



            echo("<h3>News Editor</h3>");
			echo("<form action=\"mynews\" method=\"get\">");

     $trigger = $_GET["trigger"];
	 
 //database connection
 include 'connection.php'; 
  // data functions
 include 'functions.php';

	
if ($trigger == 0) // just display insert plus current list
{
				
echo("News Item Title: </br><input type=\"text\" id=\"newstitle\" name=\"newstitle\" style=\"width:95%\" class=\"form-control\"></br>");
echo("<textarea name=\"newsitem\" class=\"texteditor\" rows=\"4\" cols=\"50\">add your news item here </textarea></br>");
echo("<input type=\"hidden\" name=\"trigger\" value=1>");
echo("<div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button></div>");
echo("<br>");
echo("</form>");

$sql = "SELECT news_item_id, date_format(item_date,'%d-%m-%Y') AS item_date, item_title FROM news_item ORDER BY item_date DESC";
echo("<br><table class=\"table table-bordered\"><tr><th>Date</th><th>Title</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting news list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["item_date"]."</td><td>".$row["item_title"]."</td><td><a href=mynews?trigger=2&newsitemid=".$row["news_item_id"]."&".SID.">Update</a></td><td><a href=mynews?trigger=3&newsitemid=".$row["news_item_id"]."&".SID." onClick=\"return confirm('Delete This account?')\">Delete</a></td></tr>");
	}
echo("</table>");
 
}	
 
if ($trigger == 1) //insert a news_item
{

echo("News Item Title: </br><input type=\"text\" id=\"newstitle\" name=\"newstitle\" style=\"width:95%\" class=\"form-control\"></br>");
echo("<textarea name=\"newsitem\" class=\"texteditor\" rows=\"4\" cols=\"50\">add your news item here </textarea></br>");
echo("<input type=\"hidden\" name=\"trigger\" value=1>");
echo("<div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button></div>");
echo("<br>");
echo("</form>");


		if ((!isSet($_GET["newstitle"])) ||
		(!isSet($_GET["newsitem"])))
		die("You must input both a title and a news item");
		
		$newstitle = escape($conn,$_GET["newstitle"]);
		$newsitem = escape($conn,$_GET["newsitem"]);
		$newsauthor = $_SESSION["name"];
		
		
		
		$sql = "INSERT INTO news_item(item_date, item_title,item_body,item_author) VALUES (CURDATE(),$newstitle,$newsitem,'$newsauthor')";
		$result = mysqli_query($conn,$sql) or die ("Error inserting record - ".mysqli_error($conn));
		
		if (mysqli_affected_rows($conn) != 1) 
		die("Error inserting runner");

$sql = "SELECT news_item_id, date_format(item_date,'%d-%m-%Y') AS item_date, item_title FROM news_item ORDER BY item_date DESC";
echo("<br><table class=\"table table-bordered\"><tr><th>Date</th><th>Title</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting news list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["item_date"]."</td><td>".$row["item_title"]."</td><td><a href=mynews?trigger=2&newsitemid=".$row["news_item_id"]."&".SID.">Update</a></td><td><a href=mynews?trigger=3&newsitemid=".$row["news_item_id"]."&".SID." onClick=\"return confirm('Delete This account?')\">Delete</a></td></tr>");
	}
echo("</table>");
}

if ($trigger == 2) // update a news item
{
if (!isset($_GET["newsitemid"]))
	die("You need to select a news item from the form");
$newsitemid = $_GET["newsitemid"];

$sql = "SELECT item_title, item_body FROM news_item WHERE news_item_id = $newsitemid";
$result = mysqli_query($conn,$sql) or die("error fetching row from runnerDb - ".mysql_error($conn));

if (mysqli_num_rows($result) == 0)
				die("Error – record not found to edit");

while ($row = mysqli_fetch_array($result))
			{
				$item_title = $row["item_title"];
				$item_body = $row["item_body"];
			}
			
echo("News Item Title: </br><input type=\"text\" id=\"newstitle\" name=\"newstitle\"  value=\"$item_title\" style=\"width:95%\" class=\"form-control\"></br>");
echo("<textarea name=\"newsitem\" class=\"texteditor\" rows=\"4\" cols=\"50\">$item_body</textarea></br>");
echo("<input type=\"hidden\" name=\"trigger\" value=4>");
echo("<input type=hidden name=newsitemid value=$newsitemid >");
echo("<div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button></div>");
echo("<br>");
echo("</form>");	
			
$sql = "SELECT news_item_id, date_format(item_date,'%d-%m-%Y') AS item_date, item_title FROM news_item ORDER BY item_date DESC";
echo("<br><table class=\"table table-bordered\"><tr><th>Date</th><th>Title</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting news list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["item_date"]."</td><td>".$row["item_title"]."</td><td><a href=mynews?trigger=2&newsitemid=".$row["news_item_id"]."&".SID.">Update</a></td><td><a href=mynews?trigger=3&newsitemid=".$row["news_item_id"]."&".SID." onClick=\"return confirm('Delete This account?')\">Delete</a></td></tr>");
	}
echo("</table>");
}

if ($trigger == 3) // delete a news item
{

echo("News Item Title: </br><input type=\"text\" id=\"newstitle\" name=\"newstitle\" style=\"width:95%\" class=\"form-control\"></br>");
echo("<textarea name=\"newsitem\" class=\"texteditor\" rows=\"4\" cols=\"50\">add your news item here </textarea></br>");
echo("<input type=\"hidden\" name=\"trigger\" value=1>");
echo("<div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button></div>");
echo("<br>");
echo("</form>");

if (!isset($_GET['newsitemid']))
			die("you must select a news item");
$newsitemid = $_GET["newsitemid"];

$sql = "DELETE FROM news_item WHERE news_item_id = $newsitemid";
$result = mysqli_query($conn, $sql) or die("Error deleting record ".mysqli_error($conn));
$numrows = mysqli_affected_rows($conn);
	if ($numrows == 1)
	{
		
$sql = "SELECT news_item_id, date_format(item_date,'%d-%m-%Y') AS item_date, item_title FROM news_item ORDER BY item_date DESC";
echo("<br><table class=\"table table-bordered\"><tr><th>Date</th><th>Title</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting news list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["item_date"]."</td><td>".$row["item_title"]."</td><td><a href=mynews?trigger=2&newsitemid=".$row["news_item_id"]."&".SID.">Update</a></td><td><a href=mynews?trigger=3&newsitemid=".$row["news_item_id"]."&".SID." onClick=\"return confirm('Delete This account?')\">Delete</a></td></tr>");
	}
echo("</table>");
		
	}
	else
	{
		echo "<p class=\"pageheading\">Delete NOT Successfull</p>"; 
$sql = "SELECT news_item_id, date_format(item_date,'%d-%m-%Y') AS item_date, item_title FROM news_item ORDER BY item_date DESC";
echo("<br><table class=\"table table-bordered\"><tr><th>Date</th><th>Title</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting news list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["item_date"]."</td><td>".$row["item_title"]."</td><td><a href=mynews?trigger=2&newsitemid=".$row["news_item_id"]."&".SID.">Update</a></td><td><a href=mynews?trigger=3&newsitemid=".$row["news_item_id"]."&".SID." onClick=\"return confirm('Delete This account?')\">Delete</a></td></tr>");
	}
echo("</table>");
	}
}

if ($trigger == 4) // do update
{
		if ((!isSet($_GET["newstitle"])) ||
		(!isSet($_GET["newsitem"])))
		die("You must input both a title and a news item");
		
		$newstitle = escape($conn,$_GET["newstitle"]);
		$newsitem = escape($conn,$_GET["newsitem"]);
		$newsitemid = $_GET["newsitemid"];
		
		
		
		$sql = "UPDATE news_item SET item_date = CURDATE(),item_title = $newstitle, item_body = $newsitem WHERE news_item_id = $newsitemid";
		$result = mysqli_query($conn, $sql) or die("Error updating record ".mysqli_error($conn));
		$numrows = mysqli_affected_rows($conn);
		
echo("News Item Title: </br><input type=\"text\" id=\"newstitle\" name=\"newstitle\" style=\"width:95%\" class=\"form-control\"></br>");
echo("<textarea name=\"newsitem\" class=\"texteditor\" rows=\"4\" cols=\"50\">add your news item here </textarea></br>");
echo("<input type=\"hidden\" name=\"trigger\" value=1>");
echo("<div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-primary\">Save</button></div>");
echo("<br>");
echo("</form>");
		
$sql = "SELECT news_item_id, date_format(item_date,'%d-%m-%Y') AS item_date, item_title FROM news_item ORDER BY item_date DESC";
echo("<br><table class=\"table table-bordered\"><tr><th>Date</th><th>Title</th><th>Update</th><th>Delete</th><tr>");
$result = mysqli_query($conn, $sql) or die("Error getting news list");
while ($row = mysqli_fetch_array($result)) 
	{
		echo("<tr><td>".$row["item_date"]."</td><td>".$row["item_title"]."</td><td><a href=mynews?trigger=2&newsitemid=".$row["news_item_id"]."&".SID.">Update</a></td><td><a href=mynews?trigger=3&newsitemid=".$row["news_item_id"]."&".SID." onClick=\"return confirm('Delete This account?')\">Delete</a></td></tr>");
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