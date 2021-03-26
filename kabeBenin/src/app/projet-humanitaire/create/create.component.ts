import { Component, OnInit } from '@angular/core';
import { ProjetHumanitaire } from 'src/app/entity/projet-humanitaire';
import { FormBuilder, FormGroup } from '@angular/forms';
import { ProduitService } from 'src/app/service/produit.service';
import { UserService } from 'src/app/service/user.service';

import { ProjetHumanitaireService } from 'src/app/service/projet-humanitaire.service';


@Component({
  selector: 'app-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.scss']
})
export class CreateProjetHumanitaireComponent implements OnInit {
  projetHumanitaireForm: FormGroup;
  constructor(private fb: FormBuilder, private userService: UserService, private produitService: ProduitService, private projetHumanitaire: ProjetHumanitaireService) { }
 
  ngOnInit(): void {
    this.projetHumanitaireForm=this.fb.group({
      libelle: '',
      description: '',
      photo: ''
    })

  }
  save() {


    let values = this.projetHumanitaireForm.value
    console.log(values)
    this.projetHumanitaire.save(values).subscribe(

      () => '',
      () => '',
      () => alert('User has been add successfully')
    );

  }

}
