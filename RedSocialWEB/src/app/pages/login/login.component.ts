import { Component, OnInit } from '@angular/core';
import { UsuarioModule } from '../../models/usuario/usuario.module';
import Swal from 'sweetalert2';
import { ApiServiceService } from '../../services/api-service.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  usuarioModel: UsuarioModule = new UsuarioModule();
  formData: FormData = new FormData();
  respuestaDatos: any;
  datosJsonParser: any;

  constructor(
    private apiService: ApiServiceService,
    private router: Router
  ) { }

  ngOnInit(): void {
    this.validarUsuarioLocal();
  }

  mensajeAlerta(mensaje: string): void {
    Swal.fire({
      icon: 'info',
      title: 'Advertencia',
      text: mensaje
    });
  }

  validarFormulario(): void {
    if (this.usuarioModel.usuario === '' || this.usuarioModel.password === '') {
      this.mensajeAlerta('Ingresa tu usuario y contraseña por favor');
    } else {
      this.formData.append('usuario', this.usuarioModel.usuario);
      this.formData.append('password', this.usuarioModel.password);
      this.apiService.loginUsuario(this.formData).subscribe(
        res => {
          this.respuestaDatos = res;
          console.log(this.respuestaDatos['Mensaje'][0]);
          localStorage.setItem('UsuarioST', JSON.stringify(this.respuestaDatos['Mensaje'][0]));
          Swal.fire({
            icon: 'success',
            title: 'Bienvenido!!',
            text: 'Sesión iniciada correctamente'
          });
          this.router.navigateByUrl('inicio');
        },
        err => {
          this.respuestaDatos = err;
          const mensaje = this.respuestaDatos['error']['Mensaje'];
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: mensaje
          });
        }
      );
    }
  }

  validarUsuarioLocal(): void {
    this.respuestaDatos = localStorage.getItem('UsuarioST');
    this.datosJsonParser = JSON.parse(this.respuestaDatos);
    if (this.datosJsonParser !== null) {
      Swal.fire({
        icon: 'success',
        title: 'Bienvenido',
        text: 'Iniciando sesión automáticamente!!'
      });
      this.router.navigateByUrl('inicio');
    }
  }

}
