import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ApiServiceService } from 'src/app/services/api-service.service';
import { MatDialog, MatDialogConfig} from '@angular/material/dialog';
import { PostDialogComponent } from '../../components/post-dialog/post-dialog.component';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-inicio',
  templateUrl: './inicio.component.html',
  styleUrls: ['./inicio.component.scss']
})
export class InicioComponent implements OnInit {

  respuestaDatos: any;
  datosJsonParser: any;

  resDatosPost: any;
  datosJsonPost: any;

  formData: FormData = new FormData();

  constructor(
    private dialog: MatDialog,
    private router: Router,
    private apiService: ApiServiceService
  ) { }

  ngOnInit(): void {
    this.validarUsuarioLocal();
    this.cargarArticulos();
  }

  validarUsuarioLocal(): void {
    this.respuestaDatos = localStorage.getItem('UsuarioST');
    this.datosJsonParser = JSON.parse(this.respuestaDatos);
    if (this.datosJsonParser === null) {
      this.router.navigateByUrl('login');
    }
  }

  cargarArticulos(): void {
    this.formData.append('idUsuario', this.datosJsonParser.id);
    this.apiService.listarPost(this.formData).subscribe(
      data => {
        this.resDatosPost = data;
        this.datosJsonPost = this.resDatosPost['Mensaje'];
      }, err => {
        document.getElementById('postError')!.innerHTML = '<h1>Aún no existen post públicos!</h1>';
      }
    );
  }

  loadFormPost(): void {
    const dialogConfig = new MatDialogConfig();
    dialogConfig.disableClose = false;
    dialogConfig.autoFocus = true;
    dialogConfig.width = '500px';
    const dialogRef = this.dialog.open(PostDialogComponent, dialogConfig);
    dialogRef.afterClosed().subscribe(data => {
      this.validarUsuarioLocal();
      this.cargarArticulos();
    });
  }

  eliminarPublicacion(): void {
    Swal.fire({
      icon: 'warning',
      title: 'Advertencia',
      text: 'Desea eliminar esta publicación?'
    });
  }
}
