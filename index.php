<!DOCTYPE html>

<html>
	
<head>

	
</head>

<body>
	
	<div id = "Header">
		<hr><h2 class="ex1"> LOGIN </h2></hr>
	</div>

	<div class="center" id = content>
		<form method="post" action="index.php"">
			<table>
				<tr>
					<td> <b class="ex1"> Username:   </b></td>
					<td><input type="text" name="username" placeholder="Username" required /></td>
				</tr>
				<tr>
					<td> <b class="ex1"> Password:   </b></td>
					<td><input type="password" name="password" placeholder="********" required /></td>
				</tr>
			</table>
			<input type="submit" name="submit" value="Login" />
		</form>
		<div>
		<a href= "registerUser.php" class="text-center new-account">Create an Account </a>
	    </div>
		<div>
		<a href= "registerBusiness.php" class="text-center new-account">Create a Business Account </a>
	    </div>
		
	</div>


</body>
</html>