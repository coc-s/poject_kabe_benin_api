import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})

export class DonService {


  save(don: any){


    return this.httpClient.post('http://localhost:8000/api/dons',don);

  }
  constructor(private httpClient : HttpClient) { }
}
