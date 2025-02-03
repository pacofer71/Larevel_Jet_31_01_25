<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowUserPosts extends Component
{
    use WithPagination;

    public string $campo = "id", $orden = "desc";
    public string $buscar = "";

    public function render()
    {
        $posts = Post::with('category')
            ->where('user_id', Auth::user()->id)
            ->where(function ($query) {
                $query->where('titulo', 'like', "%{$this->buscar}%")
                    ->orWhere('estado', 'like', "%{$this->buscar}%");
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

    public function updatingBuscar(){
            $this->resetPage(); 
    }
}
