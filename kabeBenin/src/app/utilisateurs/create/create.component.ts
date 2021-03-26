import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { UserService } from 'src/app/service/user.service';

@Component({
  selector: 'app-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.scss']
})
export class CreateComponent implements OnInit {
userForm: FormGroup;
  constructor(private fb : FormBuilder,private userService: UserService) { }

  ngOnInit(): void {


    this.userForm= this.fb.group({

      nom: '',
      prenom: '',
      dateNaissance: '',
      email: '',
      password: '',
      telephone: '',
      adresse: '',
      codePostal: '',
      ville: ''
    })
  }

  save(){


  let values =this.userForm.value
  console.log(values)
  this.userService.save(values).subscribe(

()=>'',
()=>'',
()=>alert('User has been add successfully')
  );

  

  }

}
