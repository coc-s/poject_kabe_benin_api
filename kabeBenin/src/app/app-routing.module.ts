import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { InterfaceLoginComponent } from './interface-login/interface-login.component';
import { CreateComponent } from './utilisateurs/create/create.component';

import { CreateEvenementComponent } from './evenement/create/create.component';



const routes: Routes = [
  { path:'login', component: InterfaceLoginComponent},
  { path:'create', component: CreateComponent },
  { path: 'evenement', component: CreateEvenementComponent }


];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }