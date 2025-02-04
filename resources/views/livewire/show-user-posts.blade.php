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
                            [ 'p-2 rounded-xl text-white font-bold' , 
                            'bg-red-500 hover:bg-red-600'=>$item->estado=='Borrador',
                            'bg-green-500 hover:bg-green-600'=>$item->estado=='Publicado',
                            ]) wire:click="cambiarEstado({{$item->id}})">
                            {{$item->estado}}
                        </button>
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Remove</a>
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
</x-self.base>