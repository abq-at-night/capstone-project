<?php require_once ("head-utils.php");?>

<?php require_once ("navbar.php");?>


<!-- Note: This code was adapted from the following source: https://bootsnipp.com/snippets/KB5EW -->


<div class="container">

	<div id="event-entry-form" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">Create a new event</div>
			</div>
			<div class="panel-body">
				<form method="post" action=".">


						<div id="event-title" class="form-group required">
							<label for="event-title" class="control-label col-md-4  requiredField">Event Title<span class="asteriskField">*</span> </label>
							<div class="controls col-md-8 ">
								<input class="input-md textinput textInput form-control" id="event-title" maxlength="30" name="event-title" placeholder="Enter an Event Title." style="margin-bottom: 10px" type="text" />
							</div>
						</div>

					<div id="event-venue" class="form-group">
						<label for="event-venue" class="control-label col-md-4  requiredField">Event Venue</label>
						<div class="controls col-md-8 ">
							<input class="input-md textinput textInput form-control" id="event-venue" name="event-venue" placeholder="Enter an Event Venue. (optional)" style="margin-bottom: 10px" type="text" />
						</div>
					</div>

					<div id="event-date-start-time" class="form-group required">
						<label for="event-date-start-time" class="control-label col-md-4  requiredField">Event Date and Start Time<span class="asteriskField">*</span> </label>
						<div class="controls col-md-8 ">
							<input class="input-md textinput textInput form-control" id="event-date-start-time" name="event-date-start-time" placeholder="Y-M-D H:M:S" style="margin-bottom: 10px" type="text" />
						</div>
					</div>

						<div id="event-description" class="form-group required">
							<label for="event-description" class="control-label col-md-4  requiredField">Event Description<span class="asteriskField">*</span> </label>
							<div class="controls col-md-8 ">
								<input class="input-md textinput form-control" id="event-description" name="event-description" placeholder="Enter an event description." style="margin-bottom: 10px" type="text" />
							</div>
						</div>


						<div id="div_id_password2" class="form-group required">
							<label for="id_password2" class="control-label col-md-4  requiredField"> Re:password<span class="asteriskField">*</span> </label>
							<div class="controls col-md-8 ">
								<input class="input-md textinput textInput form-control" id="id_password2" name="password2" placeholder="Confirm your password" style="margin-bottom: 10px" type="password" />
							</div>
						</div>
						<div id="div_id_name" class="form-group required">
							<label for="id_name" class="control-label col-md-4  requiredField"> full name<span class="asteriskField">*</span> </label>
							<div class="controls col-md-8 ">
								<input class="input-md textinput textInput form-control" id="id_name" name="name" placeholder="Your Frist name and Last name" style="margin-bottom: 10px" type="text" />
							</div>
						</div>
						<div id="div_id_gender" class="form-group required">
							<label for="id_gender"  class="control-label col-md-4  requiredField"> Gender<span class="asteriskField">*</span> </label>
							<div class="controls col-md-8 "  style="margin-bottom: 10px">
								<label class="radio-inline"> <input type="radio" name="gender" id="id_gender_1" value="M"  style="margin-bottom: 10px">Male</label>
								<label class="radio-inline"> <input type="radio" name="gender" id="id_gender_2" value="F"  style="margin-bottom: 10px">Female </label>
							</div>
						</div>
						<div id="div_id_company" class="form-group required">
							<label for="id_company" class="control-label col-md-4  requiredField"> company name<span class="asteriskField">*</span> </label>
							<div class="controls col-md-8 ">
								<input class="input-md textinput textInput form-control" id="id_company" name="company" placeholder="your company name" style="margin-bottom: 10px" type="text" />
							</div>
						</div>
						<div id="div_id_catagory" class="form-group required">
							<label for="id_catagory" class="control-label col-md-4  requiredField"> catagory<span class="asteriskField">*</span> </label>
							<div class="controls col-md-8 ">
								<input class="input-md textinput textInput form-control" id="id_catagory" name="catagory" placeholder="skills catagory" style="margin-bottom: 10px" type="text" />
							</div>
						</div>
						<div id="div_id_number" class="form-group required">
							<label for="id_number" class="control-label col-md-4  requiredField"> contact number<span class="asteriskField">*</span> </label>
							<div class="controls col-md-8 ">
								<input class="input-md textinput textInput form-control" id="id_number" name="number" placeholder="provide your number" style="margin-bottom: 10px" type="text" />
							</div>
						</div>
						<div id="div_id_location" class="form-group required">
							<label for="id_location" class="control-label col-md-4  requiredField"> Your Location<span class="asteriskField">*</span> </label>
							<div class="controls col-md-8 ">
								<input class="input-md textinput textInput form-control" id="id_location" name="location" placeholder="Your Pincode and City" style="margin-bottom: 10px" type="text" />
							</div>
						</div>
						<div class="form-group">
							<div class="controls col-md-offset-4 col-md-8 ">
								<div id="div_id_terms" class="checkbox required">
									<label for="id_terms" class=" requiredField">
										<input class="input-ms checkboxinput" id="id_terms" name="terms" style="margin-bottom: 10px" type="checkbox" />
										Agree with the terms and conditions
									</label>
								</div>

							</div>
						</div>
						<div class="form-group">
							<div class="aab controls col-md-4 "></div>
							<div class="controls col-md-8 ">
								<input type="submit" name="Signup" value="Signup" class="btn btn-primary btn btn-info" id="submit-id-signup" />
								or <input type="button" name="Signup" value="Sign Up with Facebook" class="btn btn btn-primary" id="button-id-signup" />
							</div>
						</div>

					</form>
			</div>
		</div>
	</div>
</div>