import {RouterModule, Routes} from "@angular/router";
import {SplashComponent} from "./splash/splash.component";

import{AppComponent} from "./app.component"

import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {DeepDiveInterceptor} from "./shared/interceptors/deep-dive.interceptor";
import {SignInComponent} from "./sign-in/sign-in.component";




export const routes: Routes = [
	{path: "", component: SplashComponent}
];

export const allAppComponents = [AppComponent, SplashComponent, SignInComponent];


export const providers: any[] =[
	// TODO services go here, comma separated, please
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true}

];

export const routing = RouterModule.forRoot(routes);