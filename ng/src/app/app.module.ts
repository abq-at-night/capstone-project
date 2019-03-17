import { NgModule,  } from '@angular/core';
import {HttpClientModule} from "@angular/common/http";
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import {ReactiveFormsModule} from "@angular/forms";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes.module"
import { AppComponent } from './app.component';
import {NgbModule} from "@ng-bootstrap/ng-bootstrap";
import {FontAwesomeModule} from "@fortawesome/angular-fontawesome";


@NgModule({
  imports:      [ BrowserModule, FormsModule, HttpClientModule, routing, ReactiveFormsModule, NgbModule, FontAwesomeModule],
  declarations: [ ...allAppComponents, AppComponent],
  bootstrap:    [ AppComponent ],
  providers:    [ appRoutingProviders]
})
export class AppModule { }
