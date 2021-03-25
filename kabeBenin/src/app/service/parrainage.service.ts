import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ParrainageService {

  save(parrainage: any){

    return this.httpClient.post('http://localhost:8000/api/parrainages', parrainage);

  }

  constructor(private httpClient : HttpClient) { }
}
