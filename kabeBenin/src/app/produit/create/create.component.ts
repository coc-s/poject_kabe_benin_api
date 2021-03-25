import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { ProduitService } from 'src/app/service/produit.service';
import { UserService } from 'src/app/service/user.service';




@Component({
  selector: 'app-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.scss']
})
export class CreateProduitComponent implements OnInit {
produitForm: FormGroup;

  constructor(private fb: FormBuilder, private userService: UserService, private produitService: ProduitService) { }

  ngOnInit(): void {
    this.produitForm=this.fb.group({
      libelle: '',
      description: '',
      prix: '',
      quantite: '',
      disponibilite: '',
      photo: ''

    })

  }
  save() {


    let values = this.produitForm.value
    console.log(values)
    this.produitService.save(values).subscribe(

      () => '',
      () => '',
      () => alert('User has been add successfully')
    );

    }


}
