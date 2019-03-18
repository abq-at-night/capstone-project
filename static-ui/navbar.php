<?php require_once("head-utils.php"); ?>

<main>
	<nav class="navbar navbar-dark">
		<img class="pb-2" src="../src/img/abq-at-night-logo-white.png" alt="logo white">
		<!--form-->
		<form class="form-group row no-gutters" id="searchbar">
			<!--input-->
			<div class="col">
				<input class="form-control d-inline-block" type="search" placeholder="Search" aria-label="Search">
			</div>
			<!--button-->
			<div class="col-sm-2">
				<span><button class="btn btn-outline-danger ml-sm-2" type="submit">Search</button></span>
			</div>
			<!--input-->
			<div class="col">
				<input class="form-control d-inline-block" type="date" placeholder="Search" aria-label="Search">
			</div>
			<!--button-->
			<div class="col-sm-2">
				<span><button class="btn btn-outline-danger ml-sm-2" type="submit">Search</button></span>
			</div>
		</form>
	</nav>
</main>
