import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BanqueAssociation } from '../entity/banque-association';

@Injectable({
  providedIn: 'root'
})
export class BanqueAssociationService {

  save(banqueAssociation: any){

  return this.httpClient.post('http://localhost:8000/api/banque-associations', banqueAssociation);
  }

constructor(private httpClient : HttpClient) { }

}
