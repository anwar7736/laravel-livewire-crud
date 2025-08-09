<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
class PurchaseCreate extends Component
{
    public $searchItems = [], $items = [], $search;

    public function addItem($id){
        $product = Product::find($id);
        if(isset($this->items[$id])){
            $this->items[$id]['quantity']++;
        }else{
            $this->items[$id] = [
            'sku' => $product->sku,
            'name' => $product->name,
            'image' => $product->image,
            'price' => $product->price,
            'quantity' => 1,
        ];
        }

        $this->search = '';
        $this->searchItems = [];
    }

    public function removeItem($id){
        unset($this->items[$id]);
    }

    public function addPurchase() {
        dd($this->items);
    }

    public function render()
    {
        if(strlen($this->search) >= 3){
            $products = Product::where(function($query){
                $query->where('sku', 'LIKE', "%{$this->search}%")
                     ->orWhere('name', 'LIKE', "%{$this->search}%");
            })->select('id', 'sku', 'name', 'price', 'image')->get();

            if(count($products) === 0){
                flash()->error('No Product Found!');
            }
            else if(count($products) === 1){
                $this->addItem($products[0]->id);
            }else{
                $this->searchItems = $products;
            }
        }

        return view('livewire.purchase-create');
    }
}
