import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { InterfaceLoginComponent } from './interface-login/interface-login.component';
import { CreateComponent } from './utilisateurs/create/create.component';
import { CreateParrainageComponent } from './parrainage/create/create.component';

const routes: Routes = [
  { path:'login', component: InterfaceLoginComponent},
  { path:'create', component: CreateComponent },
  { path:'parrainage', component: CreateParrainageComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
