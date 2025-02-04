<?php

namespace App\Livewire\Forms;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormCrearPost extends Form
{
    
    #[Rule(['required', 'string', 'min:3', 'max:100', 'unique:posts,titulo'])]
    public string $titulo="";
    
    #[Rule(['required', 'string', 'min:15', 'max:300'])]
    public string $contenido="";

    #[Rule(['required', 'exists:categories,id'])]    
    public int $category_id=-1;
    
    #[Rule(['required', 'in:Publicado,Borrador'])]
    public string $estado="";
    
    #[Rule(['nullable', 'image', 'max:2048'])]
    public $imagen;

    //public function rules(): array{
    //    return [];
    //}

    public function formStore(){
        $this->validate();
        Post::create([
            'titulo'=>$this->titulo,
            'contenido'=>$this->contenido,
            'estado'=>$this->estado,
            'category_id'=>$this->category_id,
            'user_id'=>Auth::user()->id,
            'imagen'=>$this->imagen?->store('images/posts/') ?? 'images/noimage.png'
        ]);

    }
    public function formReset(){
        $this->resetValidation();
        $this->reset();
    }
}
