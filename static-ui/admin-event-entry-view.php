<?php require_once("head-utils.php");?>

<?php require_once ("navbar.php");?>


<!-- Note: This code was adapted from the following source: https://bootsnipp.com/snippets/KB5EW -->


<div class="container">

	<div id="event-entry-form" class="mainbox col d-flex justify-content-center">
		<div class="panel panel-info d-inline w-50">
			<div class="panel-heading">
				<div class="h4 panel-title mb-2 mt-2">Create a new event.</div>
			</div>


				<div id="event-image" class="form-group required">
					<label for="event-image" class="control-label requiredField">Image<span class="asteriskField">*</span> </label>
					<div class="controls">
						<input class="input textInput form-control mb-1" id="event-image" name="event-image" placeholder="www.eventimageurl.com" type="text" />
					</div>
				</div>

					<div id="event-title" class="form-group required">
						<label for="event-title" class="control-label  requiredField">Title<span class="asteriskField">*</span> </label>
						<div class="controls">
							<input class="input textInput form-control mb-1" id="event-title" name="event-title" placeholder="Enter a title." type="text" />
						</div>
					</div>

				<div id="event-venue" class="form-group">
					<label for="event-venue" class="control-label">Venue</label>
					<div class="controls">
						<input class="input textInput form-control mb-1" id="event-venue" name="event-venue" placeholder="Enter a venue. (optional)" type="text" />
					</div>
				</div>

				<div id="event-latitude" class="form-group">
					<label for="event-latitude" class="control-label">Latitude</label>
					<div class="controls">
						<input class="input textInput form-control mb-1" id="event-latitude" name="event-latitude" placeholder="BE CAREFUL! Only six digits are allowed after the decimal." type="text" />
					</div>
				</div>

				<div id="event-longitude" class="form-group">
					<label for="event-longitude" class="control-label">Longitude</label>
					<div class="controls">
						<input class="input textInput form-control mb-1" id="event-longitude" name="event-longitude" placeholder="BE CAREFUL! Only six digits are allowed after the decimal." type="text" />
					</div>
				</div>

				<div id="event-date-start-time" class="form-group required">
					<label for="event-date-start-time" class="control-label requiredField">Start Date and Start Time<span class="asteriskField">*</span> </label>
					<div class="controls">
						<input class="input textInput form-control mb-1" id="event-date-start-time" name="event-date-start-time" placeholder="Y-M-D H:M:S" type="text" />
					</div>
				</div>

				<div id="event-date-end-time" class="form-group required">
					<label for="event-date-end-time" class="control-label requiredField">End Date and End Time<span class="asteriskField">*</span> </label>
					<div class="controls">
						<input class="input textInput form-control mb-1" id="event-date-end-time" name="event-date-end-time" placeholder="Y-M-D H:M:S" type="text" />
					</div>
				</div>

				<div id="event-price" class="form-group">
					<label for="event-price" class="control-label">Price</label>
					<div class="controls">
						<input class="input textInput form-control mb-1" id="event-price" name="event-price" placeholder="Enter the price. (optional)" type="text" />
					</div>
				</div>

				<div id="event-age-requirement" class="form-group">
					<label for="event-age-requirement" class="control-label">Age Requirement</label>
					<div class="controls">
						<input class="input textInput form-control mb-1" id="event-age-requirement" name="event-age-requirement" placeholder="Enter the age requirement. (optional)" type="text" />
					</div>
				</div>

					<div id="event-description" class="form-group required">
						<label for="event-description" class="control-label requiredField">Event Description<span class="asteriskField">*</span> </label>
						<div class="controls">
							<input class="input form-control mb-1" id="event-description" name="event-description" placeholder="Enter an event description." type="text" />
						</div>
					</div>

					<div id="event-venue-website" class="form-group">
						<label for="event-venue-website" class="control-label">Venue Website</label>
						<div class="controls">
							<input class="input textInput form-control mb-1" id="event-venue-website" name="event-venue-website" placeholder="www.eventvenue.com (optional)" type="text" />
						</div>
					</div>

				<div id="event-promoter-website" class="form-group">
					<label for="event-promoter-website-website" class="control-label">Promoter Website</label>
					<div class="controls">
						<input class="input textInput form-control mb-1" id="event-promoter-website" name="event-promoter-website" placeholder="www.promoterwebsite.com (optional)" type="text" />
					</div>
				</div>

			<!-- Button trigger modal -->
			<div class="container">
				<div class="row">
					<div class="col text-center mb-2">
						<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#tagModal">
						Launch tag modal
						</button>
					</div>
				</div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="tagModal" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label data-error="wrong" data-success="right" for="tags">Enter the event tags here.</label>
							<input type="text" id="tags" class="form-control validate">
						</div>

					</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save changes</button>
						</div>
					</div>
				</div>
			</div>

			</div>

						<div class="form-group d-flex justify-content-center">
							<div class="aab controls"></div>
							<div class="controls">
								<input type="submit" name="Submit" value="Submit" class="btn btn-danger btn btn-info" id="submit" />
							</div>
						</div>

</div>