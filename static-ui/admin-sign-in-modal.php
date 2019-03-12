<?php require_once ("head-utils.php");?>

<?php require_once ("navbar.php");?>

<main>

	<! Modal -->
	<div class="modal fade" id="admin-sign-in" tabindex="-1" role="dialog" aria-labelledby="admin-sign-in" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content gray">
				<div class="modal-header gray">
					<h5 class="modal-title" id="admin-sign-in">Admin Sign-in</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body gray">
					<form class="form-control lg" id="form" action="" method="post">
						<div class="info">
							<input class="form-control" id="username" type="text" name="username" placeholder=" Username" />
							<input class="form-control" id="password" type="text" name="password" placeholder=" Password" />
						</div>
					</form>
					<div class="modal-footer">
						<input class="btn" type="submit" value="Sign In">
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
