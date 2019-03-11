<?php require_once ("head-utils.php");?>

<?php require_once ("navbar.php");?>


<!-- Note: This code was adapted from the following source: https://bootsnipp.com/snippets/KB5EW -->


<div class="container">

	<div id="event-entry-form" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">Create a new event.</div>
			</div>
			<div class="panel-body">
				<form method="post" action=".">


					<div id="event-image" class="form-group required">
						<label for="event-image" class="control-label col-md-4 requiredField">Image<span class="asteriskField">*</span> </label>
						<div class="controls col-md-8 ">
							<input class="input-md textinput textInput form-control" id="event-image" maxlength="30" name="event-image" placeholder="www.eventimageurl.com" style="margin-bottom: 10px" type="text" />
						</div>
					</div>

						<div id="event-title" class="form-group required">
							<label for="event-title" class="control-label col-md-4  requiredField">Title<span class="asteriskField">*</span> </label>
							<div class="controls col-md-8 ">
								<input class="input-md textinput textInput form-control" id="event-title" maxlength="30" name="event-title" placeholder="Enter a title." style="margin-bottom: 10px" type="text" />
							</div>
						</div>

					<div id="event-venue" class="form-group">
						<label for="event-venue" class="control-label col-md-4">Venue</label>
						<div class="controls col-md-8 ">
							<input class="input-md textinput textInput form-control" id="event-venue" name="event-venue" placeholder="Enter a venue. (optional)" style="margin-bottom: 10px" type="text" />
						</div>
					</div>

					<div id="event-date-start-time" class="form-group required">
						<label for="event-date-start-time" class="control-label col-md-4  requiredField">Start Date and Start Time<span class="asteriskField">*</span> </label>
						<div class="controls col-md-8 ">
							<input class="input-md textinput textInput form-control" id="event-date-start-time" name="event-date-start-time" placeholder="Y-M-D H:M:S" style="margin-bottom: 10px" type="text" />
						</div>
					</div>

					<div id="event-date-end-time" class="form-group required">
						<label for="event-date-end-time" class="control-label col-md-4  requiredField">End Date and End Time<span class="asteriskField">*</span> </label>
						<div class="controls col-md-8 ">
							<input class="input-md textinput textInput form-control" id="event-date-end-time" name="event-date-end-time" placeholder="Y-M-D H:M:S" style="margin-bottom: 10px" type="text" />
						</div>
					</div>

					<div id="event-price" class="form-group">
						<label for="event-price" class="control-label col-md-4">Price</label>
						<div class="controls col-md-8 ">
							<input class="input-md textinput textInput form-control" id="event-price" name="event-price" placeholder="Enter the price. (optional)" style="margin-bottom: 10px" type="text" />
						</div>
					</div>

					<div id="event-age-requirement" class="form-group">
						<label for="event-age-requirement" class="control-label col-md-4">Age Requirement</label>
						<div class="controls col-md-8 ">
							<input class="input-md textinput textInput form-control" id="event-age-requirement" name="event-age-requirement" placeholder="Enter the age requirement. (optional)" style="margin-bottom: 10px" type="text" />
						</div>
					</div>

						<div id="event-description" class="form-group required">
							<label for="event-description" class="control-label col-md-4  requiredField">Event Description<span class="asteriskField">*</span> </label>
							<div class="controls col-md-8 ">
								<input class="input-md textinput form-control" id="event-description" name="event-description" placeholder="Enter an event description." style="margin-bottom: 10px" type="text" />
							</div>
						</div>

						<div id="event-venue-website" class="form-group">
							<label for="event-venue-website" class="control-label col-md-4">Venue Website</label>
							<div class="controls col-md-8 ">
								<input class="input-md textinput textInput form-control" id="event-venue-website" name="event-venue-website" placeholder="www.eventvenue.com (optional)" style="margin-bottom: 10px" type="text" />
							</div>
						</div>

					<div id="event-promoter-website" class="form-group">
						<label for="event-promoter-website-website" class="control-label col-md-4">Promoter Website</label>
						<div class="controls col-md-8 ">
							<input class="input-md textinput textInput form-control" id="event-promoter-website" name="event-promoter-website" placeholder="www.promoterwebsite.com (optional)" style="margin-bottom: 10px" type="text" />
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