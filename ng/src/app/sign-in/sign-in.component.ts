import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

import {SignInService} from "../shared/services/sign-in.service";
import {SessionService} from "../shared/services/session.service";

import {Status} from "../shared/interfaces/status";
import {SignIn} from "../shared/interfaces/sign.in";


@Component({
	templateUrl: "./sign-in.component.html",
	selector: "sign-in",
	styles: [`
		#SignInBox {
			background: #fff;
			border-radius: 2px;
			margin: 1rem;
			box-shadow: 6px 6px 20px rgba(0,0,0,0.1), 6px 6px 20px rgba(0,0,0,0.1);
		}
		.btn:hover {
			box-shadow: 0 3px 15px rgba(193,46,60,0.6), 0 3px 15px rgba(193,46,60,0.6);
		}
		.alert {
			box-shadow: 6px 6px 20px rgba(0,0,0,0.1), 6px 6px 20px rgba(0,0,0,0.1);
		}
	`]
})

export class SignInComponent implements OnInit {

	signInForm: FormGroup;


	status: Status = null;

	constructor(
		private formBuilder: FormBuilder,
		private router: Router,
		private signInService: SignInService,
		private sessionService: SessionService
	){}

	ngOnInit(): void {
		this.signInForm = this.formBuilder.group({
				adminEmail: ["", [Validators.maxLength(128), Validators.required]],
				adminPassword: ["", [Validators.maxLength(48), Validators.required]],
			}
		);

	}

	createSignIn(): void {

		 let signIn: SignIn = {adminEmail: this.signInForm.value.adminEmail, adminPassword: this.signInForm.value.adminPassword};

		this.signInService.postSignIn(signIn)
			.subscribe(status => {
				this.status = status;

				if (this.status.status === 200) {
					this.sessionService.setSession();
					this.signInForm.reset();
					location.reload();

					this.router.navigate(["/signed-in-homeview"]);
				}
			});


	}
	signOut() :void {
		this.signInService.getSignOut();
	}
}


