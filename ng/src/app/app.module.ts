import { NgModule,  } from '@angular/core';
import {HttpClientModule} from "@angular/common/http";
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import {ReactiveFormsModule} from "@angular/forms";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes.module"
import { AppComponent } from './app.component';
import {NgbModule} from "@ng-bootstrap/ng-bootstrap";
import {FontAwesomeModule} from "@fortawesome/angular-fontawesome";
import {JwtModule} from "@auth0/angular-jwt";

const JwtHelper = JwtModule.forRoot({
  config: {
    tokenGetter: () => {
      return localStorage.getItem("jwt-token");
    },
    skipWhenExpired:true,
    whitelistedDomains: ["localhost:4200", "https://bootcamp-coders.cnm.edu/"],
    headerName:"X-JWT-TOKEN",
    authScheme: ""
  },
});

@NgModule({
  imports:      [ BrowserModule, FormsModule, HttpClientModule, routing, ReactiveFormsModule, NgbModule, FontAwesomeModule, JwtHelper],
  declarations: [ ...allAppComponents, AppComponent],
  bootstrap:    [ AppComponent ],
  providers:    [ appRoutingProviders]
})
export class AppModule { }
