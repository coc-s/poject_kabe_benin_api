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


@NgModule({
  declarations: [
    AppComponent,
    InterfaceLoginComponent,
    CreateComponent, 
    CreateEvenementComponent
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
  EvenementService

],

  bootstrap: [AppComponent]
})
export class AppModule { }