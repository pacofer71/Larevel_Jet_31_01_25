<x-app-layout>
    <x-self.base>
        <div class="w-1/2 mx-auto">
            <div class="mb-4">
                <a href="{{route('categories.create')}}" class="mb-4 p-2 rounded-xl text-white bg-blue-500 hover:bg-blue-700">
                    <i class="fas fa-add mr-2"></i>NUEVO
                </a>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Color
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$item->nombre}}
                        </th>
                        <td class="px-6 py-4">
                            <div class="text-center p-2 rounded-xl w-32 font-bold text-white" style="background-color:{{$item->color}}">
                                {{$item->color}}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{route('categories.destroy', $item)}}" method="POST">
                                @csrf
                                @method('delete')
                                <a href="{{route('categories.edit', $item)}}" class="mr-2">
                                    <i class="fas fa-edit text-blue-500"></i>
                                </a>
                                <button type="submit">
                                    <i class="fas fa-trash text-red-400"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </x-self.base>
    @session('mensaje')
    <script>
        Swal.fire({
            icon: "success",
            title: "{{session('mensaje')}}",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    @endsession
</x-app-layout>