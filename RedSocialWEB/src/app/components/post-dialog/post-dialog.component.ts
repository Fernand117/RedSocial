import { Component, OnInit } from '@angular/core';
import { PostModule } from '../../models/post/post.module';
import { ApiServiceService } from '../../services/api-service.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-post-dialog',
  templateUrl: './post-dialog.component.html',
  styleUrls: ['./post-dialog.component.scss']
})
export class PostDialogComponent implements OnInit {

  postModel: PostModule = new PostModule();
  formData: FormData = new FormData();
  respuestaDatos: any;
  datosJsonParser: any;

  isEmojiPickerVisible: boolean = false;

  constructor(
    private apiService: ApiServiceService
  ) { }

  ngOnInit(): void {
    this.validarUsuarioLocal();
    (document.getElementById('btnPost') as HTMLInputElement).disabled = true;
    const inputTextPost = document.getElementById('nombre');
    inputTextPost?.addEventListener('change', this.updateValue);
  }

  validarUsuarioLocal(): void {
    this.respuestaDatos = localStorage.getItem('UsuarioST');
    this.datosJsonParser = JSON.parse(this.respuestaDatos);
  }

  updateValue(e: any): void {
    if (e.target.value === '') {
      (document.getElementById('btnPost') as HTMLInputElement).disabled = true;
    } else {
      (document.getElementById('btnPost') as HTMLInputElement).disabled = false;
    }
  }

  crearPublicacion(): void {
    this.formData.append('idUsuario', this.datosJsonParser.id);
    this.formData.append('nombre', this.postModel.nombre);
    this.formData.append('post', this.postModel.post);
    this.apiService.crearPost(this.formData).subscribe(
      data => {
        this.respuestaDatos = data;
        this.datosJsonParser = this.respuestaDatos['Mensaje'];
        Swal.fire({
          icon: 'info',
          text: this.datosJsonParser
        });
      }
    );
  }

  addEmoji(event: any): void {
    this.postModel.post = `${this.postModel.post}${event.emoji.native}`;
    this.isEmojiPickerVisible = false;
  }
}
