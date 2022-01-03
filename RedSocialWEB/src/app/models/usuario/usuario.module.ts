import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';



@NgModule({
  declarations: [],
  imports: [
    CommonModule
  ]
})
export class UsuarioModule {
  usuario: string;
  email: string;
  password: string;

  constructor() {
    this.usuario = '';
    this.email = '';
    this.password = '';
  }
}
