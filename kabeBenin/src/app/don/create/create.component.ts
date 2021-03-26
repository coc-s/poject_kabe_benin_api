import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { DonService } from 'src/app/service/don.service';



@Component({
  selector: 'app-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.scss']
})
export class CreateDonComponent implements OnInit {
donForm: FormGroup;

  constructor(private fb: FormBuilder, private donService: DonService) { }

  ngOnInit(): void {
    this.donForm=this.fb.group({
      montant: '',
      date: ''

    })

  }
  save() {


    let values = this.donForm.value
    console.log(values)
    this.donService.save(values).subscribe(

      () => '',
      () => '',
      () => alert('User has been add successfully')
    );

    }


}



