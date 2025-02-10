<x-app-layout>
    <x-self.base>
        <h3 class="text-2xl font-bold text-center mb-4">Formulario de Contacto</h3>
        <div class="p-4 border-2 border-black rounded-2xl shadow-2xl mx-auto w-1/2">
            <form action="{{route('contacto.procesar')}}" method="POST">
                @csrf
                <!-- Campo Nombre -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" id="name" name="name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <x-input-error for="name" />
                </div>

                <!-- Campo Email -->
                 @guest
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <x-input-error for="email" />
                </div>
                @endguest

                <!-- Campo Cuerpo del mensaje -->
                <div class="mb-4">
                    <label for="body" class="block text-sm font-medium text-gray-700">Mensaje</label>
                    <textarea id="body" name="body" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    <x-input-error for="body" />
                </div>

                <!-- Botones -->
                <div class="flex justify-between items-center">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Enviar</button>
                    <button type="reset" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancelar</button>
                </div>
            </form>
        </div>
    </x-self.base>
</x-app-layout>