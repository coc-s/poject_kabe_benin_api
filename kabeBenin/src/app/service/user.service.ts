import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class UserService {


  save(utilisateur: any){


    return this.httpClient.post('http://localhost:8000/api/utilisateurs',utilisateur);

  }
  constructor(private httpClient : HttpClient) { }
}
