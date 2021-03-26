import { Component, OnInit } from '@angular/core';
import { BanqueAssociationService } from 'src/app/service/banque-association.service';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { ParrainageService } from 'src/app/service/parrainage.service';



@Component({
  selector: 'app-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.scss']
})
export class CreateBanqueAssociationComponent implements OnInit {
  public banqueAssociationForm: FormGroup;

  constructor(private fb: FormBuilder, private parrainageService: ParrainageService, private banqueAssociationService: BanqueAssociationService) { }

  ngOnInit(): void {
    this.banqueAssociationForm=this.fb.group({
      totalDons: ''
    })
    
  }
  save() {


    let values = this.banqueAssociationForm.value
    console.log(values)
    this.banqueAssociationService.save(values).subscribe(

      () => '',
      () => '',
      () => alert('User has been add successfully')
    );



  }

}
