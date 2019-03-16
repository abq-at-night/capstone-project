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

	createEventForm: FormGroup;

	status: Status = {status:null, message:"", type:null};

	constructor(
		private router: Router,
		private eventService: EventService,
		private formBuilder: FormBuilder
	){}

	ngOnInit(): void {
		this.createEventForm = this. formBuilder.group({
			ageRequirement: ["", [Validators.maxLength(128)]],
			address: ["", [Validators.maxLength(255), Validators.required]],
			description: ["", [Validators.maxLength(500)]],
			endTime: ["", [Validators.maxLength(6), Validators.required]],
			image: ["", [Validators.maxLength(256), Validators.required]],
			price: ["", [Validators.maxLength(32)]],
			promoterWebsite: ["", [Validators.maxLength(256)]],
			startTime: ["", [Validators.maxLength(6), Validators.required]],
			title: ["", [Validators.maxLength(128), Validators.required]],
			venue: ["", [Validators.maxLength(128), Validators.required]],
			venueWebsite: ["", [Validators.maxLength(256)]]
		});
	}

	eventEntry() : void {
		let newEvent : Event = {eventId:null, eventAdminId:null, eventAgeRequirement: this.createEventForm.value.ageRequirement, eventDescription: this.createEventForm.value.description, eventEndTime: this.createEventForm.value.endTime, eventImage: this.createEventForm.value.image, eventLat: this.createEventForm.value.address, eventLng: this.createEventForm.value.address, eventPrice: this.createEventForm.value.price, eventPromoterWebsite: this.createEventForm.value.promoterWebsite, eventStartTime: this.createEventForm.value.startTime, eventTitle: this.createEventForm.value.title, eventVenue: this.createEventForm.value.venue, eventVenueWebsite: this.createEventForm.value.venueWebsite}
		this.eventService.createEvent(newEvent)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					alert("Your event was created successfully!");
				}
		});
	}
}