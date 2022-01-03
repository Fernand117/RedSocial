import { Component, OnInit } from '@angular/core';
import { UsuarioModule } from '../../models/usuario/usuario.module';
import { NgForm } from '@angular/forms';
import { AlertasModule } from '../../components/alertas/alertas.module';
import Swal from 'sweetalert2';
import { ApiServiceService } from '../../services/api-service.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-registro',
  templateUrl: './registro.component.html',
  styleUrls: ['./registro.component.scss']
})
export class RegistroComponent implements OnInit {

  usuarioModel: UsuarioModule = new UsuarioModule();
  alertas: AlertasModule = new AlertasModule();
  formData: FormData = new FormData();

  data: any;
  jsonData: any;

  constructor(
    private apiService: ApiServiceService,
    private router: Router
  ) { }

  ngOnInit(): void {
  }

  validarFormulario(form: NgForm): void {
    if (this.usuarioModel.usuario === '' || this.usuarioModel.email === '' || this.usuarioModel.password === '') {
      Swal.fire({
        icon: 'warning',
        title: 'Error',
        text: 'Por favor ingrese todos los datos que se le solicitan.'
      });
      form.reset();
    } else {
      this.formData.append('usuario', this.usuarioModel.usuario);
      this.formData.append('email', this.usuarioModel.email);
      this.formData.append('password', this.usuarioModel.password);

      this.apiService.registrar(this.formData).subscribe(
        resJson => {
          this.data = resJson;
          this.jsonData = this.data['Mensaje'];
          Swal.fire({
            icon: 'info',
            title: 'Respuesta JSON',
            text: this.jsonData
          });
          this.router.navigateByUrl('/login');
        }
      );
    }
  }
}
