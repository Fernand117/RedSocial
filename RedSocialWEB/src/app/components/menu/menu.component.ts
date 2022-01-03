import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-menu',
  templateUrl: './menu.component.html',
  styleUrls: ['./menu.component.scss']
})
export class MenuComponent implements OnInit {

  respuestaDatos: any;
  datosJsonParser: any;

  constructor(
    private router: Router
  ) { }

  ngOnInit(): void {
    this.validarUsuarioLocal();
  }

  cerrarSesion(): void {
    localStorage.removeItem('UsuarioST');
    this.router.navigateByUrl('/login');
  }

  validarUsuarioLocal(): void {
    this.respuestaDatos = localStorage.getItem('UsuarioST');
    this.datosJsonParser = JSON.parse(this.respuestaDatos);
  }

}
