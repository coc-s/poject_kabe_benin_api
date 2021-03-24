export class Produit {
    
    id: number;
    libelle: string;
    description: string;
    prix: Float32Array;
    quantite: boolean;
    disponibilite: string;
    photo: string;



    constructor(id: number,
        libelle: string,
        description: string,
        prix: Float32Array,
        quantite: boolean,
        disponibilite: string,
        photo: string) {

        this.id = id;
        this.libelle = libelle;
        this.description = description;
        this.prix = prix;
        this.quantite = quantite;
        this.disponibilite = disponibilite;
        this.photo = photo;



                        }

    }
