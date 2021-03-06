import {Component} from "@angular/core";



@Component({
	templateUrl: "navbar.component.html",
	selector: "navbar",
	styles: [`
		.navbar {
			background-image: linear-gradient(to bottom, #000000, #080002, #0f0002, #140103, #190102, #1e0303, #210404, #250604, #2a0906, #300a08, #370b0a, #3d0b0b);
		}

		.navbar img {
			max-width: 150px;
			min-width: 150px;
		}

		#searchbar {
			margin-bottom: 3rem;
		}

		@media (max-width: 459px) {
			#searchbar
			{
				margin-right: auto;
				margin-left: auto;
				margin-bottom: 1rem;
			}
		}

		@media (min-width: 459px) and (max-width: 575.5px) {
			#searchbar
			{
				margin: 1rem auto 1rem auto;
			}
		}

		@media (max-width: 459px) {
			#searchbar .form-control
			{
				margin-top: 1rem;
				margin-bottom: 1rem;
			}
		}

		/*@media (max-width: 459px) {
			#searchbar button
			{
				display: block;
				margin-left: auto;
		
			}
		}*/

		@media (max-width: 459px) {
			.navbar img
			{
				max-width: 150px;
				margin: 1rem auto 1rem auto;
			}
		}
	`]
})

export class NavbarComponent {}