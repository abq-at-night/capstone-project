import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";

import {Status} from "../shared/interfaces/status";
import {Event} from "../shared/interfaces/event";
import {EventService} from "../shared/services/event.service";
import {faAngleDoubleDown} from "@fortawesome/free-solid-svg-icons/faAngleDoubleDown";


@Component({
	templateUrl: "card.component.html",
	selector: "card",

	styles: [`
		
		#Jumbotron:hover {
			background: #fff;
			max-width: 600px;
			border-radius: 2px;
			box-shadow: 0 4px 9px rgba(0, 0, 0, 0.16), 0 4px 8px rgba(0, 0, 0, 0.23);
		}
		
		#Jumbotron {
			margin-left: auto;
			margin-right: auto;
			background: #fff;
			max-width: 600px;
			border-radius: 2px;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.16), 0 2px 4px rgba(0, 0, 0, 0.23);
		}
			
		#Img {
			max-width: 100%;
		}
		
		#Venue {
			color: red;
		}

		.btn {
			font-size: 160%;
			font-weight: 700;
			display: flex;
			justify-content: center;
			color: red;
			background-color: transparent;
			box-shadow: none;
		 }

		.btn:hover {
			text-shadow: 0px 0px 1px rgba(255, 158, 158, .9);
			color: red;
			background-color: transparent;
			box-shadow: none;
		}
		
		#Link {
			color: red;
		}
		
		#Link2 {
			color: red;
		}
		
	`]
})

export class CardComponent implements OnInit {

	events: any[] = [];
	status: Status = null;
	faangledoubledown = faAngleDoubleDown;

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