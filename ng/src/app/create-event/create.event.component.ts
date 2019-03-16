import {Component, OnInit, Input} from "@angular/core";
import {Router} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Status} from "../shared/interfaces/status";
import {Event} from "../shared/interfaces/event";
import {EventService} from "../shared/services/event.service";

@Component({
	templateUrl: "create.event.component.html",
	selector: "create-event-form",
	styles: [`
		h3 {
			color: #c12e3c;
		}
	`]
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
			eventAgeRequirement: ["", [Validators.maxLength(128)]],
			eventAddress: ["", [Validators.maxLength(255), Validators.required]],
			eventDescription: ["", [Validators.maxLength(500)]],
			eventEndTime: ["", [Validators.maxLength(6), Validators.required]],
			eventImage: ["", [Validators.maxLength(256), Validators.required]],
			eventPrice: ["", [Validators.maxLength(32)]],
			eventPromoterWebsite: ["", [Validators.maxLength(256)]],
			eventStartTime: ["", [Validators.maxLength(6), Validators.required]],
			eventTitle: ["", [Validators.maxLength(128), Validators.required]],
			eventVenue: ["", [Validators.maxLength(128), Validators.required]],
			eventVenueWebsite: ["", [Validators.maxLength(256)]]
		});
	}

	eventEntry() : void {
		let newEvent : Event = {eventId:null, eventAdminId:null, eventAgeRequirement: this.createEventForm.value.eventAgeRequirement, eventDescription: this.createEventForm.value.eventDescription, eventEndTime: this.createEventForm.value.eventEndTime, eventImage: this.createEventForm.value.eventImage, eventLat: this.createEventForm.value.eventAddress, eventLng: this.createEventForm.value.eventAddress, eventPrice: this.createEventForm.value.eventPrice, eventPromoterWebsite: this.createEventForm.value.eventPromoterWebsite, eventStartTime: this.createEventForm.value.eventStartTime, eventTitle: this.createEventForm.value.eventTitle, eventVenue: this.createEventForm.value.eventVenue, eventVenueWebsite: this.createEventForm.value.eventVenueWebsite};
		this.eventService.createEvent(newEvent)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					alert("Your event was created successfully!");
				}
		});
	}
}