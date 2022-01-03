import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ApiServiceService {

  //private url = 'http://127.0.0.1:8000/api/';
  private url = 'http://www.serverfer.com/redSocialApi/api/';

  constructor(
    private http: HttpClient
  ) { }

  registrar(datos: any) {
    return this.http.post(`${this.url}usuario/registrar`, datos);
  }

  loginUsuario(datos: any) {
    return this.http.post(`${this.url}usuario/login`, datos);
  }

  editarPerfil(datos: any) {
    return this.http.post(`${this.url}usuario/editar/perfil`, datos);
  }

  eliminarPerfil(datos: any) {
    return this.http.post(`${this.url}eliminar/perfil`, datos);
  }

  listarPost(datos: any) {
    return this.http.post(`${this.url}post/listar`, datos);
  }

  crearPost(datos: any) {
    return this.http.post(`${this.url}post/crear`, datos);
  }
}
