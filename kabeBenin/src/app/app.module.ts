import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { InterfaceLoginComponent } from './interface-login/interface-login.component';
import { InscriptionComponent } from './inscription/inscription.component';
import { ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { UserService } from './service/user.service';
import { AdminComponent } from './admin/admin.component';
import { AccueilComponent } from './accueil/accueil.component';
import { MenuAccueilComponent } from './menu-accueil/menu-accueil.component';
import { VillageKabeComponent } from './village-kabe/village-kabe.component';
import { ConnexionComponent } from './connexion/connexion.component';
import { FaireUnDonComponent } from './faire-un-don/faire-un-don.component';
import { NousContacterComponent } from './nous-contacter/nous-contacter.component';
import { PaiementDonComponent } from './paiement-don/paiement-don.component';
import { ProjetComponent } from './projet/projet.component';
import { VenteComponent } from './vente/vente.component';
import { EvenementComponent } from './evenement/evenement.component';

@NgModule({
  declarations: [
    AppComponent,
    InterfaceLoginComponent,
    InscriptionComponent,
    AdminComponent,
    AccueilComponent,
    MenuAccueilComponent,
    VillageKabeComponent,
    ConnexionComponent,
    FaireUnDonComponent,
    NousContacterComponent,
    PaiementDonComponent,
    ProjetComponent,
    VenteComponent,
    EvenementComponent
  ],
  imports: [
    
    BrowserModule,
    AppRoutingModule,
    NgbModule,
    ReactiveFormsModule,
    HttpClientModule
  ],
  providers: [UserService],
  bootstrap: [AppComponent]
})
export class AppModule { }
