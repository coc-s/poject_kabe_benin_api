import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ProjetHumanitaireService {

  save(projetHumanitaire: any) {

    return this.httpClient.post('http://localhost:8000/api/projetHumanitaires', projetHumanitaire);

  }


  constructor(private httpClient: HttpClient) { }
}
