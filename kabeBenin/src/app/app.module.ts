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
import { ParrainageService } from './service/parrainage.service';
import { CreateParrainageComponent } from './parrainage/create/create.component';

@NgModule({
  declarations: [
    AppComponent,
    InterfaceLoginComponent,
    CreateComponent, 
    CreateParrainageComponent 
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
  ParrainageService
],

  bootstrap: [AppComponent]
})
export class AppModule { }
