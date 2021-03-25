
import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { ProduitService } from 'src/app/service/produit.service';
import { UserService } from 'src/app/service/user.service';




@Component({
  selector: 'app-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.scss']
})
export class CreateEvenementComponent implements OnInit {
produitForm: FormGroup;

  constructor(private fb: FormBuilder, private userService: UserService, private evenementService: EvenementService) { }

  ngOnInit(): void {
    this.produitForm=this.fb.group({
      libelle: '',
      Date: ''

    })

  }
  save() {


    let values = this.evenementForm.value
    console.log(values)
    this.evenementService.save(values).subscribe(

      () => '',
      () => '',
      () => alert('User has been add successfully')
    );

    }


}
