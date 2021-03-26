
import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { EvenementService } from 'src/app/service/evenement.service';




@Component({
  selector: 'app-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.scss']
})
export class CreateEvenementComponent implements OnInit {
evenementForm: FormGroup;

  constructor(private fb: FormBuilder, private evenementService: EvenementService) { }

  ngOnInit(): void {
    this.evenementForm=this.fb.group({
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
