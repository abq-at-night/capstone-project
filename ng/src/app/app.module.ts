import { NgModule,  } from '@angular/core';
import {HttpClientModule} from "@angular/common/http";
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import {ReactiveFormsModule} from "@angular/forms";
import {allAppComponents, appRoutingProviders, providers, routing} from "./app.routes.module"
import { AppComponent } from './app.component';


@NgModule({
  imports:      [ BrowserModule, FormsModule, HttpClientModule, routing, ReactiveFormsModule],
  declarations: [ ...allAppComponents, AppComponent],
  bootstrap:    [ AppComponent ],
  providers:    [providers, appRoutingProviders]
})
export class AppModule { }
