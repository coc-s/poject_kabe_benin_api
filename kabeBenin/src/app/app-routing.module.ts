import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AccueilComponent } from './accueil/accueil.component';
import { InterfaceLoginComponent } from './interface-login/interface-login.component';
import { InscriptionComponent } from './inscription/inscription.component';
import { ConnexionComponent } from './connexion/connexion.component';
import { EvenementComponent } from './evenement/evenement.component';
import { VillageKabeComponent } from './village-kabe/village-kabe.component';
import { FaireUnDonComponent } from './faire-un-don/faire-un-don.component';
import { NousContacterComponent } from './nous-contacter/nous-contacter.component';
import { PaiementDonComponent } from './paiement-don/paiement-don.component';
import { ProjetComponent } from './projet/projet.component';
import { VenteComponent } from './vente/vente.component';




const routes: Routes = [
  { path: '', component: AccueilComponent },
  { path:'login', component: InterfaceLoginComponent },
  { path: 'inscription', component: InscriptionComponent },
  { path: 'accueil', component: AccueilComponent },
  { path: 'connexion', component: ConnexionComponent },
  { path: 'evenement', component: EvenementComponent },
  { path: 'villagekabe', component: VillageKabeComponent },
  { path: 'faireUnDon', component: FaireUnDonComponent },
  { path: 'paiementDon', component: PaiementDonComponent },
  { path: 'nousContacter', component: NousContacterComponent },
  { path: 'projet', component: ProjetComponent },
  { path: 'vente', component: VenteComponent }
  

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
