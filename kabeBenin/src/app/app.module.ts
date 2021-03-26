import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { InterfaceLoginComponent } from './interface-login/interface-login.component';
import { CreateComponent } from './utilisateurs/create/create.component';
import { ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { UserService } from './service/user.service';
import { CreateEvenementComponent } from './evenement/create/create.component';
import { EvenementService } from './service/evenement.service';
import { CreateDonComponent } from './don/create/create.component';
import { DonService } from './service/don.service';



@NgModule({
  declarations: [
    AppComponent,
    InterfaceLoginComponent,
    CreateComponent, 
    CreateEvenementComponent,
    CreateDonComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    NgbModule,
    ReactiveFormsModule,
    HttpClientModule
  ],
  providers: [
  UserService,
  EvenementService,
  DonService

],

  bootstrap: [AppComponent]
})
export class AppModule { }