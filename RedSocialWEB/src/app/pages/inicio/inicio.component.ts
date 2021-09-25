import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-inicio',
  templateUrl: './inicio.component.html',
  styleUrls: ['./inicio.component.scss']
})
export class InicioComponent implements OnInit {

  respuestaDatos: any;
  datosJsonParser: any;

  constructor(
    private router: Router
  ) { }

  ngOnInit(): void {
    this.validarUsuarioLocal();
  }

  validarUsuarioLocal(): void {
    this.respuestaDatos = localStorage.getItem('UsuarioST');
    this.datosJsonParser = JSON.parse(this.respuestaDatos);
    if (this.datosJsonParser === null) {
      this.router.navigateByUrl('login');
    }
  }

}
