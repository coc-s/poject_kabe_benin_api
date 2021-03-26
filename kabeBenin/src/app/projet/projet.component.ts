import { Component, OnInit } from '@angular/core';



@Component({

  selector: 'app-projet',

  templateUrl: './projet.component.html',

  styleUrls: ['./projet.component.scss']

})

export class ProjetComponent implements OnInit {




  myIndex;

  x;

  constructor() {



    this.myIndex=0

    this.x= document.getElementsByClassName("mySlides");



  }



  ngOnInit(): void {



    this.carousel()



  }



   carousel() {



    var i;




    for (i = 0; i < this.x.length; i++) {

      this.x[i].setAttribute('style','display: none;')

      console.log(this.x[i])

    }

    this.myIndex++;

    if ( this.myIndex > this.x.length) {

      this.myIndex = 1

    }

   this.x[this.myIndex-1].setAttribute('style','display: block; width:50%')

    console.log(this.myIndex)

    //setTimeout(this.carousel, 3000); // Change image every 2 seconds

    setTimeout(

      () => {

       this.carousel();

      }, 3000

    );




}



}