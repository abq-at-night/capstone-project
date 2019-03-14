import {Component, ViewChild, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";




import {SignInService} from "../services/sign.in.service";
import {SessionService} from "../services/session.service";


import {Status} from "../interfaces/status";
import {SignIn} from "../interfaces/sign.in";


declare let $: any;


@Component({
	templateUrl: ("./sign-in.component.html"),
	selector: "sign-in"
})

export class SignInComponent implements OnInit {

	signInForm: FormGroup;

	signIn: SignIn = {adminUsername:null, adminPassword:null};
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

		//let signIn = new SignIn(this.signInForm.value.adminUsername, this.signInForm.value.adminPassword);

		this.signInService.postSignIn(this.signIn)
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


