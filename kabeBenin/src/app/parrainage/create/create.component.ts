import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';

@Component({
  selector: 'app-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.scss']
})
export class CreateComponent implements OnInit {
userForm: FormGroup;

  constructor(private fb : FormBuilder) { }

  ngOnInit(): void {
    this.userForm=this.fb.group({

      nomEnfant: '',
      prenomEnfant: '',
      dateNaissEnfant: '',
      sexe: '',
      dateParrainage: '',
      ecole: '',
      village: ''
    })

    
  }

}
