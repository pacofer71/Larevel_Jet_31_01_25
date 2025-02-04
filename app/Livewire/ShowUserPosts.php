<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ShowUserPosts extends Component
{
    use WithPagination;

    public string $campo = "id", $orden = "desc";
    public string $buscar = "";
    
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

        return view('livewire.show-user-posts', compact('posts'));
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
}
