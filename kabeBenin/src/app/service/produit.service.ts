import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ProduitService {

  save(produit: any) {

    return this.httpClient.post('http://localhost:8000/api/produits', produit);

  }

    constructor(private httpClient : HttpClient) { }
}
