import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { ParrainageService } from 'src/app/service/parrainage.service';

@Component({
  selector: 'app-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.scss']
})
export class CreateParrainageComponent implements OnInit {
public parrainageForm: FormGroup;

  constructor(private fb: FormBuilder, private parrainageService: ParrainageService ) { }

  ngOnInit(): void {
    this.parrainageForm=this.fb.group({

      nomEnfant: '',
      prenomEnfant: '',
      dateNaissEnfant: '',
      sexe: '',
      dateParrainage: '',
      ecole: '',
      village: '',
      photo: ''
    })

    
  }
  save() {


    let values = this.parrainageForm.value
    console.log(values)
    this.parrainageService.save(values).subscribe(

      () => '',
      () => '',
      () => alert('User has been add successfully')
    );



  }

}
