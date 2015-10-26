<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "00254boM", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>
ChangePassword page
<hr>
<?PHP
	echo "ID : ".$_SESSION['ID']."<br>";
	echo "NAME : ".$_SESSION['NAME']."<br>";
	echo "SURNAME : ".$_SESSION['SURNAME']."<br>";
	echo "<a href='Logout.php'>Logout</a>"."<br>"."<br>";
	
	
?>

<?PHP
	if(isset($_POST['submit'])){
		$ID = $_SESSION['ID'];
		$oldPassword = trim($_POST['oldPassword']);
		$newpassword = trim($_POST['newpassword']);
		$query = "SELECT PASSWORD FROM AA_LOGIN WHERE ID='$ID'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		if($row){
			$CheckPassword = $row['PASSWORD'];
			if($CheckPassword == $oldPassword){
			$query = "UPDATE AA_LOGIN SET PASSWORD='$newpassword' WHERE ID='$ID' " ;
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			echo "Password is updated.";
			echo '<script>window.location = "MemberPage.php";</script>';
			}else{
				echo "Oldpassword is not corect.";}
			
		}else{
			echo "select from database is NULL.";
		}
		
		
	};
	oci_close($conn);
?>

<form action='ChangePassword.php' method='post'>
	OldPassword <br>
	<input name='oldPassword' type='input'><br>
	NewPassword<br>
	<input name='newpassword' type='password'><br><br>
	<input name='submit' type='submit' value='Submit'>
</form>