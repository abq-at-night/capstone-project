import {Component, OnInit, Input} from "@angular/core";
import {Router} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Status} from "../shared/interfaces/status";
import {Event} from "../shared/interfaces/event";
import {EventService} from "../shared/services/event.service";
//import { NgbActiveModal, NgbModal } from '@ng-bootstrap/ng-bootstrap';
//import {DatetimePickerComponent} from "../datetime-picker/datetime-picker.component";

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

	dateTimePickerForm: FormGroup = null;

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
			eventVenueWebsite: ["", [Validators.maxLength(256)]],
			eventDate: [""]
		});
		this.dateTimePickerForm = this.formBuilder.group({
			date: ["", [Validators.required]],
			time: ["", [Validators.required]]
		});
	}

	eventEntry() : void {

		let startTime = new Date(this.createEventForm.value.eventDate.year, this.createEventForm.value.eventDate.month -1, this.createEventForm.value.eventDate.day, this.createEventForm.value.eventStartTime.hour, this.createEventForm.value.eventStartTime.minute);

		let endTime = new Date(this.createEventForm.value.eventDate.year, this.createEventForm.value.eventDate.month -1, this.createEventForm.value.eventDate.day, this.createEventForm.value.eventEndTime.hour, this.createEventForm.value.eventEndTime.minute);

		console.log(startTime.getTime());
		console.log(endTime.getTime());

		//let endTime = new Date(this.createEventForm.value.eventEndTime.hour, this.createEventForm.value.eventEndTime.minute);
		console.log(this.createEventForm.value.eventDate);

		let newEvent : Event = {eventId:null, eventAdminId:null, eventAgeRequirement: this.createEventForm.value.eventAgeRequirement, eventDescription: this.createEventForm.value.eventDescription, eventEndTime: endTime.getTime(), eventImage: this.createEventForm.value.eventImage, eventLat: null, eventLng: null, eventPrice: this.createEventForm.value.eventPrice, eventPromoterWebsite: this.createEventForm.value.eventPromoterWebsite, eventStartTime: startTime.getTime(), eventTitle: this.createEventForm.value.eventTitle, eventVenue: this.createEventForm.value.eventVenue, eventVenueWebsite: this.createEventForm.value.eventVenueWebsite, eventAddress: this.createEventForm.value.eventAddress};

		this.eventService.createEvent(newEvent)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.createEventForm.reset();
				}
		});
	}

}





