import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class EvenementService {

  save(evenement: any) {

    return this.httpClient.post('http://localhost:8000/api/evenements', evenement);

  }

    constructor(private httpClient : HttpClient) { }
}

