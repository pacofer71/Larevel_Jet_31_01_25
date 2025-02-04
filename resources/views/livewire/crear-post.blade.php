<div>
    <x-button class="font-bold" wire:click="$set('openCrear', true)"><i class="fas fa-add mr-2"></i>NUEVO</x-button>
    <x-dialog-modal wire:model="openCrear">
        <x-slot name="title">
            CREAR POST
        </x-slot>
        <x-slot name="content">
            <!-- Título -->
            <div class="mb-6">
                <label for="title" class="block text-lg font-medium text-gray-700 mb-2">Título</label>
                <input type="text" wire:model="cform.titulo"
                    id="title" name="title" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Escribe el título del post">
                <x-input-error for="cform.titulo" />
            </div>

            <!-- Contenido -->
            <div class="mb-6">
                <label for="content" class="block text-lg font-medium text-gray-700 mb-2">Contenido</label>
                <textarea wire:model="cform.contenido"
                    id="content" name="content" rows="6" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Escribe el contenido del post"></textarea>
                <x-input-error for="cform.contenido" />
            </div>

            <!-- Categoría -->
            <div class="mb-6">
                <label for="category" class="block text-lg font-medium text-gray-700 mb-2">Categoría</label>
                <select id="category" wire:model="cform.category_id" name="category" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                  <option selected>Seleccionar categoría</option>
                  @foreach($categorias as $item)
                  <option value="{{$item->id}}">{{$item->nombre}}</option>
                  @endforeach
                </select>
                <x-input-error for="cform.category_id" />
            </div>

            <!-- Estado -->
            <div class="mb-6 flex items-center space-x-8">
                <span class="text-lg font-medium text-gray-700">Estado</span>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center space-x-2">
                        <input type="radio" wire:model="cform.estado" 
                        id="published" name="estado" value="Publicado" class="h-4 w-4 text-indigo-600">
                        <span class="text-gray-700">Publicado</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" id="draft" name="estado" wire:model="cform.estado" 
                        value="Borrador" class="h-4 w-4 text-indigo-600">
                        <span class="text-gray-700">Borrador</span>
                    </label>
                </div>
                <x-input-error for="cform.estado" />
            </div>
            <!-- Imagen del post -->
            <div>
                <label for="imagen_c" class="block text-lg font-medium text-gray-700 mb-2">Imagen</label>
                <div class="w-full h-80 bg-gray-200 relative">
                    <input wire:loading.attr="disabled" type="file" id="imagen_c" hidden accept="image/*" wire:model="cform.imagen" />
                    <label for="imagen_c" class="rounded-lg text-white font-bold absolute bottom-2 end-2 p-2 bg-black hover:bg-gray-600">
                        <i class="fas fa-upload mr-2"></i>SUBIR
                    </label>
                    @isset($cform->imagen)
                    <img src="{{$cform->imagen->temporaryUrl()}}" class="size-full bg-no-repeat bg-center bg-cover" />
                    @endisset
                </div>
            </div>
            <x-input-error for="cform.imagen" />
        </x-slot>
        <x-slot name="footer">
            <!-- Botón de Enviar -->
            <div class="flex flex-row-reverse justify-center">
                <button wire:click="store" wire:loading.attr="disabled" class="ml-2 p-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                    <i class="fas fa-paper-plane mr-2"></i> Publicar Post
                </button>
                <button wire:click="cancelar" class="p-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition duration-300">
                    <i class="fas fa-xmark mr-2"></i> Cancelar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>