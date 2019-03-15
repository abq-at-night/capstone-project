import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

import {SignInService} from "../shared/services/sign-in.service";
import {SessionService} from "../shared/services/session.service";

import {Status} from "../shared/interfaces/status";
import {SignIn} from "../shared/interfaces/sign.in";


@Component({
	templateUrl: "./sign-in.component.html",
	selector: "sign-in"
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
				adminUsername: ["", [Validators.maxLength(128), Validators.required]],
				adminPassword: ["", [Validators.maxLength(48), Validators.required]],
			}
		);

	}

	createSignIn(): void {

		 let signIn: SignIn = {adminUsername: this.signInForm.value.adminUsername, adminPassword: this.signInForm.value.adminPassword};

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


