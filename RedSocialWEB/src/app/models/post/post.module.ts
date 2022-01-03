import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';



@NgModule({
  declarations: [],
  imports: [
    CommonModule
  ]
})
export class PostModule {
  idUsuario: number;
  nombre: string;
  post: string;
  multimedia: Object;

  constructor() {
    this.idUsuario = 0;
    this.nombre = '';
    this.post = '';
    this.multimedia = Object;
  }
}
