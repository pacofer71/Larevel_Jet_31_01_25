<?php

namespace App\Livewire;

use App\Livewire\Forms\FormUpdatePost;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class ShowUserPosts extends Component
{
    use WithPagination;
    use WithFileUploads;

    public string $campo = "id", $orden = "desc";
    public string $buscar = "";

    public FormUpdatePost $uform;
    public bool $openUpdate=false;
    public bool $openDetalle=false;
    public ?Post $postDetalle=null;
    
    #[On('onPostCreado')]
    public function render()
    {
        // $posts = Post::with('category')
        //     ->where('user_id', Auth::user()->id)
        //     ->where(function ($query) {
        //         $query->where('titulo', 'like', "%{$this->buscar}%")
        //             ->orWhere('estado', 'like', "%{$this->buscar}%");
        //     })
        //     ->orderBy($this->campo, $this->orden)
        //     ->paginate(5);
        $posts = DB::table('posts')
            ->join('categories', 'category_id', '=', 'categories.id')
            ->select('posts.*', 'nombre', 'color')
            ->where('user_id', Auth::user()->id)
            ->where(function ($query) {
                $query->where('titulo', 'like', "%{$this->buscar}%")
                    ->orWhere('estado', 'like', "%{$this->buscar}%")
                    ->orWhere('nombre', 'like', "%{$this->buscar}%");
            })
            ->orderBy($this->campo, $this->orden)
            ->paginate(5);

            $categorias=Category::select('nombre', 'id')
            ->orderBy('nombre')->get();

        return view('livewire.show-user-posts', compact('posts', 'categorias'));
    }

    public function ordenar(string $campo)
    {
        $this->orden = ($this->orden == 'asc') ? 'desc' : 'asc';
        $this->campo = $campo;
    }

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function cambiarEstado(Post $post)
    {
        $this->authorize('update', $post);
        $estado = ($post->estado == 'Publicado') ? 'Borrador' : 'Publicado';
        $post->update([
            'estado' => $estado,
        ]);
    }
    //Metodos para borrar Post
    public function confirmarDelete(Post $post){
        $this->authorize('delete', $post);
        $this->dispatch('onBorrarPost', $post->id);
    }

    #[On('borrarOk')]
    public function delete(Post $post){
        $this->authorize('delete', $post);
        if(basename($post->imagen)!='noimage.png'){
            Storage::delete($post->imagen);
        }
        $post->delete();
        $this->dispatch('mensaje', 'Post Eliminado');
    }
    // Metodos para editar Post ----------------
    public function edit(Post $post){  //me abre la modal de editar
        $this->authorize('update', $post);
        $this->uform->setPost($post);
        $this->openUpdate=true;
    }
    public function update(){
        $this->authorize('update', $this->uform->post);
        $this->uform->formUpdate();
        $this->cancelar();
        $this->dispatch('mensaje', 'Post editado');
    }
    public function cancelar(){
        $this->openUpdate=false;
        $this->uform->formReset();
    }
    // metodos para detalle
    public function detalle(Post $post){
        $this->postDetalle=$post;
        $this->openDetalle=true;
    }
    public function cerrarDetalle(){
        $this->reset('postDetalle', 'openDetalle');
    }
}
