import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";

import {Status} from "../shared/interfaces/status";
import {Event} from "../shared/interfaces/event";
import {EventService} from "../shared/services/event.service";

@Component({
	templateUrl: "card.component.html",
	selector: "card",

	styles: [`
		#Jumbotron {
			background: #fff;
			max-width: 600px;
			border-radius: 2px;
			box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
		}
			
		#Img {
			max-width: 100%;
		}
		
		#Venue {
			color: red;
		}

		#Buttons  {
			background-color: transparent;
			box-shadow: none;
		}
		
	`]
})

export class CardComponent implements OnInit {

	events: any[] = [];
	status: Status = null;
	public isCollapsed = true;

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