import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";

import {Status} from "../shared/interfaces/status";
import {Event} from "../shared/interfaces/event";
import {EventService} from "../shared/services/event.service";

@Component({
	templateUrl: "card.component.html",
	selector: "event"
})

export class CardComponent implements OnInit {

	events: any[] = [];
	status: Status = null;

	constructor(
		private router: Router,
		private eventService: EventService,
	){}

	ngOnInit(): void {
		this.loadCards();
	}

	loadCards() {

		this.eventService.getAllEvents()
			.subscribe(reply =>
				this.events = reply)
			}
}