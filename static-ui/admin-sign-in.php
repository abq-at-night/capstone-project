<?php require_once ("head-utils.php");?>

<?php require_once ("navbar.php");?>

<main>

	<form>
		<div class="form-group mx-5 mt-2">
			<label for="username">Username</label>
			<input type="email" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="Enter your username.">
		</div>

		<div class="form-group mx-5">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password1" placeholder="Password">
		</div>

		<div class="form-group d-flex justify-content-center">
			<div class="aab controls"></div>
			<div class="controls">
				<input type="submit" name="Submit" value="Submit" class="btn btn-danger btn btn-info" id="submit" />
			</div>
		</div>
	</form>

</main>
