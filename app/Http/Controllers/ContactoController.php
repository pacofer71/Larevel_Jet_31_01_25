<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function pintarFormulario(){
        return view('formcorreos.fcontacto');
    }
    public function procesarFormulario(Request $request){
        $request->validate([
            'name'=>['required', 'string', 'min:5', 'max:60'],
            'email'=>(Auth::user()!=null) ? ['nullable', 'email'] : ['required', 'email'],
            'body'=>['required', 'string', 'min:10', 'max:150']
        ]);
        


        try{
            Mail::to('support@contactos.org')
            ->send(new ContactoMailable($request->name, $request->email ?? Auth::user()->email, $request->body ));    
            return redirect()->route('inicio')->with('mensaje', 'Se envio el mensaje');
        }catch(\Exception $ex){
           // dd("Error al enviar el mail: ".$ex->getMessage());
           return redirect()->route('inicio')->with('mensaje', 'No se pudo enviar el mensaje');
        }
    }
}
