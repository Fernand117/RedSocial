import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import Swal, { SweetAlertResult } from 'sweetalert2';


@NgModule({
  declarations: [],
  imports: [
    CommonModule
  ]
})
export class AlertasModule {

  private titulo: string;
  private mensaje: string;

  constructor(){
    this.titulo = '';
    this.mensaje = '';
  }

  public mensajeAlerta(tituloM: string, mensajeM: string): Promise<SweetAlertResult<any>> {
    this.titulo = tituloM;
    this.mensaje = mensajeM;
    return Swal.fire({
      icon: 'warning',
      title: this.titulo,
      text: this.mensaje
    });
  }
}
