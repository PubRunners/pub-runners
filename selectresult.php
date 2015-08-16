
<!DOCTYPE>
<?PHP
session_name('runneradmin');	
session_start();
?>
<html>
<header>
	<?PHP
	include 'header.php';
	?>
<script>
$(document).ready( function () {
    $('#resulttable').dataTable( {
    "sScrollY": "200px",
    "bPaginate": true
    } );
} );
  </script>
</header>
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
										<ul> 
						<li><a href='login'><span>Login</span></a></li>
						<li><a href='myrunner?trigger=0'><span>administration</span></a></li>
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

<?PHP
 if (isset($_SESSION["authenticated"]))
{
	echo("<div class=\"col-md-2\">");
	echo("<br>");
	echo("<ul class=\"nav nav-list\">
	<li class=\"nav-header\">Administration</li>
	<li class=\"active\"><a href=\"myrunner.php?trigger=0&".SID."\">runners</a></li>
	<!--<li><a href=\"resultwizard2.php?trigger=0&".SID."\">results</a></li> -->
	<li><a href=\"resultwizard2.php?trigger=0&".SID."\"> add results</a></li>
	<li><a href=\"selectresult.php?".SID."\">edit result</a></li>
	<li><a href=\"mytrack.php?trigger=0&".SID."\">tracks</a></li>
	<li><a href=\"mynews.php?trigger=0&".SID."\">news</a></li>
	<li><a href=\"myevents.php?trigger=0&".SID."\">events</a></li>
	<li><a href=\"mycontacts.php?trigger=0&".SID."\">contacts</a></li>
	<li><a href=\"myfrontpage?trigger=2&".SID."\">Homepage Admin</a></li>");
	IF ($_SESSION['role'] == 'SUPER')
		{
			echo("<form id=\"useradmin\" method=\"post\" action=\"useradmin.php?".SID."\">");
			echo("<input type=\"hidden\" name=\"trigger\" value=\"0\" /> ");
			echo("</form>");

			echo("<a  onclick=\"document.getElementById('useradmin').submit();\">useradmin</a></li>");
			}
			echo("</ul></div><div class=\"col-md-10\"></br>");



 //database connection
 include 'connection.php'; 
   // data functions
 include 'functions.php'; 


$sql = "SELECT result_set_id,Result FROM (select rs.result_set_id,CONCAT(CONCAT(DATE_FORMAT(rs.result_date,'%d/%m/%Y'),' - '),t.track_name) Result
										  from result_set rs 
										  join track t
										  ON (t.track_id = rs.track_id)
										  Where rs.result_set_id IN (select result_set_id from result)
										  order by rs.result_date DESC) result_table";
							
$result = mysqli_query($conn,$sql) or die("error fetching row from runnerDb - ".mysql_error($conn));

if (mysqli_num_rows($result) == 0)
				die("Error – no results found");
echo("<div class=\"col-md-4\">");
echo ("<form action=\"myresults.php\" method=\"POST\">");
echo("<fieldset>");
echo("<legend>Select a Run to Update</legend>");
echo("<select name=\"resultsetid\" class=\"form-control\">");
echo("<option> </option>");
while ($row = mysqli_fetch_array($result))

			{

				echo("<option value=".$row["result_set_id"].">".$row["Result"]."</option>");
			}
echo("</select></br>");
echo("<input type=\"hidden\" name=\"trigger\" value=0>");

echo("<div class=\"pull-right\">");

echo("<button type=\"submit\" class=\"btn btn-primary\">Next</button>");
echo("</div>");
echo("</form>");
echo("</div>");
mysqli_close($conn);
}
else
	{
		echo "I am sorry but this page is only available to admins who have <a href=\"login.php\">logged in</a>";
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