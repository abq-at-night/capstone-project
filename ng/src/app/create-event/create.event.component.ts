import {Component, OnInit, Input} from "@angular/core";
import {Router} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Status} from "../shared/interfaces/status";
import {Event} from "../shared/interfaces/event";
import {EventService} from "../shared/services/event.service";

@Component({
	templateUrl: "create.event.component.html",
	selector: "create-event-form"
})

export class CreateEventComponent implements OnInit {

	@Input() event: Event[];

	eventForm: FormGroup;

	status: Status = {status:null, message:"", type:null};

	constructor(
		private router: Router,
		private eventService: EventService,
		private formBuilder: FormBuilder
	){}

	ngOnInit(): void {
		this.eventForm = this. formBuilder.group({
			eventAgeRequirement: ["", [Validators.]],
			eventDescription: [],
			eventEndTime: [],
			eventImage: [],
			eventLat: [],
			eventLng: [],
			eventPrice: [],
			eventStartTime: [],
			eventTitle: [],
			eventPromoterWebsite: [],
			eventVenue: [],
			eventVenueWebsite: []
		});
	}

	createEvent() {

		this.eventService.createEvent(event: Event)
			.subscribe(reply =>
				this.events = reply)
	}
}