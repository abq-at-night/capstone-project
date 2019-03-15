import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";

import {SessionService} from "../shared/services/session.service";

import {Status} from "../shared/interfaces/status";
import {Event} from "../shared/interfaces/event";
import {EventService} from "../shared/services/event.service";

@Component({
	templateUrl: "./event.component.html",
	selector: "event"
})

export class EventComponent implements OnInit {

	event: Event = {
		eventId: null,
		eventAdminId: null,
		eventAgeRequirement: null,
		eventDescription: null,
		eventEndTime: null,
		eventImage: null,
		eventLat: null,
		eventLng: null,
		eventPrice: null,
		eventStartTime: null,
		eventTitle: null,
		eventPromoterWebsite: null,
		eventVenue: null,
		eventVenueWebsite: null};
	status: Status = null;

	constructor(
		private router: Router,
		private eventService: EventService,
		private sessionService: SessionService
	){}

	ngOnInit(): void {
		this.listCards();
	}

	listCards() : any {

		this.eventService.getEvent(this.event.eventId)
			.subscribe(status => {
				this.status = status;

				if (this.status.status === 200) {
					this.sessionService.setSession();
					location.reload();

					this.router.navigate(["/card"])
				}
			})
	}

	//TODO create methods for the other methods listed in the service file--but how?
}