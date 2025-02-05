<?php

namespace App\Livewire\Forms;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Form;

class FormUpdatePost extends Form
{

    public ?Post $post = null;

    public string $titulo = "";

    #[Rule(['required', 'string', 'min:15', 'max:300'])]
    public string $contenido = "";

    #[Rule(['required', 'exists:categories,id'])]
    public int $category_id = -1;

    #[Rule(['required', 'in:Publicado,Borrador'])]
    public string $estado = "";

    #[Rule(['nullable', 'image', 'max:2048'])]
    public $imagen;

    public function rules(): array
    {
        return  [
            'titulo' => ['required', 'string', 'min:3', 'max:100', 'unique:posts,titulo,' . $this->post->id],
        ];
    }
    public function setPost(Post $post) {
        $this->post=$post;
        $this->titulo=$post->titulo;
        $this->contenido=$post->contenido;
        $this->estado=$post->estado;
        $this->category_id=$post->category_id;
    }

    public function formUpdate()
    {
        $this->validate();
        $imagenVieja=$this->post->imagen;
        $this->post->update([
            'titulo' => $this->titulo,
            'contenido' => $this->contenido,
            'estado' => $this->estado,
            'category_id' => $this->category_id,
            'imagen' => $this->imagen?->store('images/posts/') ?? $imagenVieja
        ]);
        if($this->imagen && basename($imagenVieja)!='noimage.png'){
            Storage::delete($imagenVieja);
        }
    }
    public function formReset()
    {
        $this->resetValidation();
        $this->reset();
    }
}
