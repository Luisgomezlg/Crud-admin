<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithFileUploads;

class Products extends Component
{
    use WithFileUploads;
    public $products, $photo, $description, $quantity, $id_producto;
    public $modal = false;
    
    public function render()
    {
        $this->products = Product::all();
        return view('livewire.products');
    }

    public function crear()
    {
        $this->limpiar();
        $this->abrirModal();
    }

    public function abrirModal() {
        $this->modal = true;
    }
    public function cerrarModal() {
        $this->modal = false;
    }
    public function limpiar(){
        $this->photo = '';
        $this->description = '';
        $this->quantity = '';
        $this->id_producto = '';
    }
    public function editar($id)
    {
        $producto = Product::findOrFail($id);
        $this->id_producto = $id;
        $this->photo = $producto->photo;
        $this->description = $producto->description;
        $this->quantity = $producto->quantity;
        $this->abrirModal();
    }

    public function borrar($id)
    {
        Product::find($id)->delete();
        session()->flash('message', 'Registro eliminado correctamente');
    }

    public function guardar()
    {
        $image = $this->photo->store('photos', 'public');

        Product::updateOrCreate(['id'=>$this->id_producto],
            [
                'photo' => $image,
                'description' => $this->description,
                'quantity' => $this->quantity
            ]);
         session()->flash('message',
            $this->id_producto ? '¡Actualización exitosa!' : '¡Alta Exitosa!');
         
         $this->cerrarModal();
         $this->limpiar();
    }
}
