export class Utilisateur {
    id:number;
    nom:string;
    prenom:string;
    dateNaissance: Date;
    email:string;
    password:string;
    telephone:string;
    adresse:string;
    codePostal:string;
    ville:string;


    constructor( id: number,
     
    nom: string,
    prenom: string,
    dateNaissance: Date,
    email: string,
    password: string,
    telephone: string,
    adresse: string,
    codePostal: string,
    ville: string){

        this.id = id;
        this.nom=nom;
        this.prenom=prenom;
        this.dateNaissance=dateNaissance;
        this.email=email;
        this.password=password;
        this.telephone=telephone
        this.adresse=adresse;
        this.codePostal=codePostal;
        this.ville=ville;
    }


}

