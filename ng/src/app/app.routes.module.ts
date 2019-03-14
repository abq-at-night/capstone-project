import {RouterModule, Routes} from "@angular/router";
import {SplashComponent} from "./splash/splash.component";

import{AppComponent} from "./app.component"

import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {DeepDiveInterceptor} from "./shared/interceptors/deep-dive.interceptor";
import {SignInComponent} from "./sign-in/sign-in.component";
import {SignInService} from "./shared/services/sign-in.service";
import {AuthService} from "./shared/services/auth.service";
import {SessionService} from "./shared/services/session.service";
import {APP_BASE_HREF} from "@angular/common";




export const routes: Routes = [
	{path: "", component: SplashComponent},
	{path: "sign-in", component: SignInComponent}
];

export const allAppComponents = [AppComponent, SplashComponent, SignInComponent];


export const providers: any[] =[
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true}

];

const services: any[] = [AuthService, SignInService, SessionService];

export const appRoutingProviders: any[] = [providers, services];

export const routing = RouterModule.forRoot(routes);