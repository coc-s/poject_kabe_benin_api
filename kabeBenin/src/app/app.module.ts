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
import { CreateProduitComponent } from './produit/create/create.component';
import { CreateProjetHumanitaireComponent } from './projet-humanitaire/create/create.component';
import { ProjetHumanitaireService } from './service/projet-humanitaire.service';
import { CreateBanqueAssociationComponent } from './banqueAssociation/create/create.component';
import { BanqueAssociationService } from './service/banque-association.service';
import { ProduitService } from './service/produit.service';
import { AngularFileUploaderModule } from 'angular-file-uploader';

@NgModule({
  declarations: [
    AppComponent,
    InterfaceLoginComponent,
    CreateComponent, 
    CreateParrainageComponent ,
    CreateProduitComponent,
    CreateProjetHumanitaireComponent,
    CreateBanqueAssociationComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    NgbModule,
    ReactiveFormsModule,
    HttpClientModule,
    AngularFileUploaderModule
  ],
  providers: [
  UserService,
  ParrainageService,
  ProduitService,
  ProjetHumanitaireService,
  BanqueAssociationService

],

  bootstrap: [AppComponent]
})
export class AppModule { }
