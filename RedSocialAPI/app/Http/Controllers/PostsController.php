<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function listarPost(Request $request) {
        //$datos = $request->all();
        $state = new StateServerController();
        $post = DB::select('select * from posts p, usuarios u where p.idUsuario = u.id  order by p.created_at desc');
        $itemPost = json_decode(json_encode($post), true);
        for ($i = 0; $i < count($post); $i ++) {
            $itemPost[$i]['post'] = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $itemPost[$i]['post']);
        }
        return $state->mensaje($itemPost, 200);
    }

    public function listarPostById($id) {
        $post = Post::find($id);
        return $post;
    }

    public function crearPost(Request $request) {
        $datos = $request->all();

        $state = new StateServerController();
        $post = new Post();

        if (isset($datos['multimedia'])) {
            $extension = $request->file('multimedia')->getClientOriginalExtension();
            $path = base_path().'/public/';
            $nombre = '';
            switch($extension) {
                case 'mp4' or 'mkv' or 'mov' or 'flv':
                    $path = $path.'videos/';
                    $nombre = 'vid';
                break;
                case 'jpg' or 'png' or 'jpge' or 'svg':
                    $path = $path.'imagenes/';
                    $nombre = 'img';
                break;
                case 'gif':
                    $path = $path.'gif/';
                    $nombre = 'gif';
                break;
            }
            $nombre = $nombre.date('Y_m_d_h_i_s').".".$extension;
            $request->file('multimedia')->move($path, $nombre);
            $post->multimedia = $nombre;
            $post->extension = $extension;
        } else {
            $post->multimedia = "null";
            $post->extension = "";
        }

        $post->idUsuario = $datos['idUsuario'];
        $post->nombre = $datos['nombre'];
        $post->post = nl2br(htmlentities($datos['post'], ENT_QUOTES, 'UTF-8'));
        $post->save();
        $comproPost = Post::find($post->id);
        if ($comproPost != null) {
            return $state->mensaje('Post publicado.', 200);
        } else {
            return $state->mensaje('Error, no se ha podido publicar.', 404);
        }
    }

    public function editarPost(Request $request) {
        $datos = $request->all();

        $state = new StateServerController();
        $post = Post::find($datos['idPost']);

        if (isset($datos['multimedia'])) {
            $extension = $request->file('multimedia')->getClientOriginalExtension();
            $path = base_path().'/public/';
            $nombre = '';
            switch($extension) {
                case 'mp4' or 'mkv' or 'mov' or 'flv':
                    $path = $path.'videos/';
                    $nombre = 'vid';
                break;
                case 'jpg' or 'png' or 'jpge' or 'svg':
                    $path = $path.'imagenes/';
                    $nombre = 'img';
                break;
                case 'gif':
                    $path = $path.'gif/';
                    $nombre = 'gif';
                break;
            }
            $nombre = $nombre.date('Y_m_d_h_i_s').".".$extension;
            $request->file('multimedia')->move($path, $nombre);
            $post->multimedia = $nombre;
            $post->extension = $extension;
        } else {
            $post->multimedia = null;
        }

        $post->idUsuario = $datos['idUsuario'];
        $post->nombre = $datos['nombre'];
        $post->post = $datos['post'];
        $post->update();
        $comproPost = Post::find($post->id);
        if ($comproPost != null) {
            return $state->mensaje('Post publicado.', 200);
        } else {
            return $state->mensaje('Error, no se ha podido publicar.', 404);
        }
    }

    public function eliminarPost(Request $request)
    {
        $datos = $request->all();
        $state = new StateServerController();
        $post = Post::find($datos['idPost']);
        $post->delete();
        $post = Post::find($datos['idPost']);
        if ($post != null) {
            return $state->mensaje('Eror, no se pudo eliminar este post.', 404);
        } else {
            return $state->mensaje('Post eliminado correctamente', 200);
        }
    }
}
