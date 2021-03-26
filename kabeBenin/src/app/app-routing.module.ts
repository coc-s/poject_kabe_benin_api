import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { InterfaceLoginComponent } from './interface-login/interface-login.component';
import { CreateComponent } from './utilisateurs/create/create.component';
import { CreateParrainageComponent } from './parrainage/create/create.component';
import { CreateProduitComponent } from './produit/create/create.component';
import { CreateProjetHumanitaireComponent } from './projet-humanitaire/create/create.component';
import { CreateBanqueAssociationComponent } from './banqueAssociation/create/create.component';


const routes: Routes = [
  { path:'login', component: InterfaceLoginComponent},
  { path:'create', component: CreateComponent },
  { path:'parrainage', component: CreateParrainageComponent },
  { path: 'produit', component: CreateProduitComponent },
  { path: 'projetHumanitaire', component: CreateProjetHumanitaireComponent },
  { path: 'banqueAssociation', component: CreateBanqueAssociationComponent }

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
