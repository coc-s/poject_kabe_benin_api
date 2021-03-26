import { isConstructorDeclaration } from "typescript";

export class ProjetHumanitaire {
    id: number;
    libelle: string;
    description: string;
    photo: string;

constructor(id: number,
    libelle: string,
    description: string,
    photo: string){

    this.id = id;
    this.libelle = libelle;
    this.description = description;
    this.photo = photo;

    }

}
