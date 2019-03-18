import {RouterModule, Routes} from "@angular/router";
import {SplashComponent} from "./splash/splash.component";

import{AppComponent} from "./app.component"

import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {DeepDiveInterceptor} from "./shared/interceptors/deep-dive.interceptor";
import {SignInComponent} from "./sign-in/sign-in.component";
import {SignInService} from "./shared/services/sign-in.service";
import {AuthService} from "./shared/services/auth.service";
import {SessionService} from "./shared/services/session.service";
import {CardComponent} from "./card/card.component";
import {EventService} from "./shared/services/event.service";
import {CreateEventComponent} from "./create-event/create.event.component";
import {NavbarComponent} from "./shared/components/nav-bar/navbar.component";




export const routes: Routes = [
	{path: "", component: SplashComponent},
	{path: "sign-in", component: SignInComponent},
	{path: "event", component: CardComponent},
	{path: "create-event-form", component: CreateEventComponent},
	{path: "navbar", component: NavbarComponent}

];

export const allAppComponents = [AppComponent, SplashComponent, SignInComponent, CardComponent, CreateEventComponent, NavbarComponent];


export const appRoutingProviders: any[] = [AuthService, SignInService, SessionService, EventService, {provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true}];

export const routing = RouterModule.forRoot(routes);