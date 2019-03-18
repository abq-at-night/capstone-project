import {Component, OnInit, Input} from "@angular/core";
import {Router} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Status} from "../shared/interfaces/status";
import {Event} from "../shared/interfaces/event";
import {EventService} from "../shared/services/event.service";
import { NgbActiveModal, NgbModal } from '@ng-bootstrap/ng-bootstrap';

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
		this.createEventForm = this.formBuilder.group({
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

		let eventEndTime = new Date(this.createEventForm.value.eventEndTime);
		let eventEndTimeStamp = eventEndTime.getTime();
		console.log(eventEndTimeStamp);
		let eventStartTime = new Date(this.createEventForm.value.eventStartTime);
		let eventStartTimeStamp = eventStartTime.getTime();
		console.log(eventStartTimeStamp);
		let newEvent : Event = {eventId:null, eventAdminId:null, eventAgeRequirement: this.createEventForm.value.eventAgeRequirement, eventDescription: this.createEventForm.value.eventDescription, eventEndTime: eventEndTimeStamp, eventImage: this.createEventForm.value.eventImage, eventLat: null, eventLng: null, eventPrice: this.createEventForm.value.eventPrice, eventPromoterWebsite: this.createEventForm.value.eventPromoterWebsite, eventStartTime: eventStartTimeStamp, eventTitle: this.createEventForm.value.eventTitle, eventVenue: this.createEventForm.value.eventVenue, eventVenueWebsite: this.createEventForm.value.eventVenueWebsite, eventAddress: this.createEventForm.value.eventAddress};
		this.eventService.createEvent(newEvent)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.createEventForm.reset();
				}
		});
	}

}





