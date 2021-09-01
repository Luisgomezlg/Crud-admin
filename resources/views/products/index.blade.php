<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Productos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                @if(session()->has('message'))
                <div class="bg-teal-100 rounded-b text-teal-900 px-4 py-4 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <h4>{{ session('message')}}</h4>
                        </div>
                    </div>
                </div>
                @endif


                <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 my-3"><a href="{{route('products.create')}}">Nuevo</a></button>


                <table class="table-fixed w-full">
                    <thead>
                        <tr class="bg-indigo-600 text-white">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">FOTO</th>
                            <th class="px-4 py-2">DESCRIPCION</th>
                            <th class="px-4 py-2">CANTIDAD</th>
                            <th class="px-4 py-2">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $producto)
                        <tr>
                            <td class="border px-4 py-2">{{$producto->id}}</td>
                            <td class="border px-4 py-2"><img width="30" src="/photos/{{$producto->photo}}"></td>
                            <td class="border px-4 py-2">{{$producto->description}}</td>
                            <td class="border px-4 py-2">{{$producto->quantity}}</td>
                            <td class="border px-4 py-2 text-center">
                            <a href="{{route('products.edit', $producto->id)}}"> Editar</a>

                                <form action="{{route('products.destroy', $producto->id)}}" method="POST" class="formEliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class=" bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4">Borrar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(e) {
        var forms = document.querySelectorAll('.formEliminar')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault()
                    event.stopPropagation()
                    Swal.fire({
                        title: 'Está seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: '¡Sí, bórralo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                            Swal.fire(
                                '¡Eliminado!',
                                'Tu archivo ha sido eliminado.',
                                'success')
                        }
                    })
                }, false)
            });
    });
</script>