<x-self.base>
    <div class="flex w-full items-center mb-2 justify-between">
        <div>
            <x-input placeholder="Buscar..." wire:model.live="buscar" /><i class="mr-2 fas fa-search"></i>
        </div>
        <div>
            @livewire('crear-post')
        </div>
    </div>
    @if($posts->count())
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead @class([ "text-xs text-gray-700 uppercase" , "bg-green-200 dark:bg-green-700"=>!Auth::user()->is_admin,
                "bg-red-200 dark:bg-red-700"=>Auth::user()->is_admin,
                ])>
                <tr>
                    <th scope="col" class="px-16 py-3">
                        INFO
                    </th>
                    <th scope="col" class="px-16 py-3">
                        <span class="sr-only">Image</span>
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('titulo')">
                        Título<i class="ml-1 fas fa-sort"></i>
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('nombre')">
                        Categoria<i class="ml-1 fas fa-sort"></i>
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('estado')">
                        Estado<i class="ml-1 fas fa-sort "></i>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        <button wire:click="detalle({{$item->id}})">
                            <i class="fas fa-info text-lg hover:text-2xl"></i>
                        </button>
                    </td>
                    <td class="p-4">
                        <img src="{{Storage::url($item->imagen)}}" class="w-16 md:w-32 max-w-full max-h-full" alt="Imagen Post">
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        {{$item->titulo}}
                    </td>
                    <td class="px-6 py-4">
                        {{$item->nombre}}
                    </td>
                    <td class="px-6 py-4">
                        <button @class(
                            [ 'p-2 rounded-xl text-white font-bold' , 'bg-red-500 hover:bg-red-600'=>$item->estado=='Borrador',
                            'bg-green-500 hover:bg-green-600'=>$item->estado=='Publicado',
                            ]) wire:click="cambiarEstado({{$item->id}})">
                            {{$item->estado}}
                        </button>
                    </td>
                    <td class="px-6 py-4">
                        <button wire:click="edit({{$item->id}})">
                            <i class="fas fa-edit text-lg hover:text-2xl"></i>
                        </button>
                        <button wire:click="confirmarDelete({{$item->id}})">
                            <i class="fas fa-trash text-lg hover:text-2xl"></i>
                        </button>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div class="mt-2">
        {{$posts->links()}}
    </div>
    @else
    <p @class([ "w-full p-4 rounded-xl shadow-xl font-bold" , "bg-green-200 dark:bg-green-700"=>!Auth::user()->is_admin,
        "bg-red-200 dark:bg-red-700"=>Auth::user()->is_admin,
        ])>
        No se encontró ningún post o aún no ha escrito ninguno.
    </p>
    @endif
    <!----------------------- Modal para Editar --------------------------->
    @isset($uform->post)
    <x-dialog-modal wire:model="openUpdate">
        <x-slot name="title">
            EDITAR POST
        </x-slot>
        <x-slot name="content">
            <!-- Título -->
            <div class="mb-6">
                <label for="title" class="block text-lg font-medium text-gray-700 mb-2">Título</label>
                <input type="text" wire:model="uform.titulo"
                    id="title" name="title" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Escribe el título del post">
                <x-input-error for="uform.titulo" />
            </div>

            <!-- Contenido -->
            <div class="mb-6">
                <label for="content" class="block text-lg font-medium text-gray-700 mb-2">Contenido</label>
                <textarea wire:model="uform.contenido"
                    id="content" name="content" rows="6" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Escribe el contenido del post"></textarea>
                <x-input-error for="uform.contenido" />
            </div>

            <!-- Categoría -->
            <div class="mb-6">
                <label for="category" class="block text-lg font-medium text-gray-700 mb-2">Categoría</label>
                <select id="category" wire:model="uform.category_id" name="category" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option selected>Seleccionar categoría</option>
                    @foreach($categorias as $item)
                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
                <x-input-error for="uform.category_id" />
            </div>

            <!-- Estado -->
            <div class="mb-6 flex items-center space-x-8">
                <span class="text-lg font-medium text-gray-700">Estado</span>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center space-x-2">
                        <input type="radio" wire:model="uform.estado"
                            id="published" name="estado" value="Publicado" class="h-4 w-4 text-indigo-600">
                        <span class="text-gray-700">Publicado</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" id="draft" name="estado" wire:model="uform.estado"
                            value="Borrador" class="h-4 w-4 text-indigo-600">
                        <span class="text-gray-700">Borrador</span>
                    </label>
                </div>
                <x-input-error for="uform.estado" />
            </div>
            <!-- Imagen del post -->
            <div>
                <label for="imagen_u" class="block text-lg font-medium text-gray-700 mb-2">Imagen</label>
                <div class="w-full h-80 bg-gray-200 relative">
                    <input wire:loading.attr="disabled" type="file" id="imagen_u" hidden accept="image/*" wire:model="uform.imagen" />
                    <label for="imagen_u" class="rounded-lg text-white font-bold absolute bottom-2 end-2 p-2 bg-black hover:bg-gray-600">
                        <i class="fas fa-upload mr-2"></i>SUBIR
                    </label>
                    @isset($uform->imagen)
                    <img src="{{$uform->imagen->temporaryUrl()}}" class="size-full bg-no-repeat bg-center bg-cover" />
                    @else
                    <img src="{{Storage::url($uform->post->imagen)}}" class="size-full bg-no-repeat bg-center bg-cover" />
                    @endisset
                </div>
            </div>
            <x-input-error for="uform.imagen" />
        </x-slot>
        <x-slot name="footer">
            <!-- Botón de Enviar -->
            <div class="flex flex-row-reverse justify-center">
                <button wire:click="update" wire:loading.attr="disabled" class="ml-2 p-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                    <i class="fas fa-paper-plane mr-2"></i> Editar Post
                </button>
                <button wire:click="cancelar" class="p-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition duration-300">
                    <i class="fas fa-xmark mr-2"></i> Cancelar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
    @endisset
    <!-------------------------  Modal para detalle ------------------------>
    @isset($postDetalle)
    <x-dialog-modal wire:model="openDetalle">
        <x-slot name="title">
            Detalle Post
        </x-slot>
        <x-slot name="content">
            <div class="w-full rounded-lg overflow-hidden shadow-lg bg-white">
                <!-- Imagen del post -->
                <img class="w-full h-56 object-cover" src="{{Storage::url($postDetalle->imagen)}}" alt="Post Image">

                <div class="px-6 py-4">
                    <!-- Título -->
                    <div class="font-bold text-xl mb-2">{{$postDetalle->titulo}}</div>

                    <!-- Contenido -->
                    <p class="text-gray-700 text-base mb-4">
                    {{$postDetalle->contenido}}
                    </p>

                    <!-- Categoría -->
                    <p class="text-sm text-blue-500 font-semibold">Categoría: <span class="text-gray-700">{{$postDetalle->category->nombre}}</span></p>

                    <!-- Fecha de actualización -->
                    <p class="text-sm text-gray-500 mt-2">Última actualización: <span class="text-gray-700">{{$postDetalle->updated_at->format('d/m/Y, H:i:s')}}</span></p>

                    <!-- Estado (Publicado o Borrador) -->
                    <div class="flex items-center mt-4">
                        <i class="fas fa-circle text-green-500 mr-2"></i> <!-- Icono de estado publicado -->
                        <span class="text-sm font-semibold text-gray-700">{{$postDetalle->estado}}</span>
                    </div>
                </div>
            </div>

        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                <x-button wire:click="cerrarDetalle">CERRAR</x-button>
            </div>
        </x-slot>
    </x-dialog-modal>
    @endisset
</x-self.base>