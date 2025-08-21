<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Validation\ValidationException;

class PurchaseCreate extends Component
{
    public $searchItems = [], $items = [], $search, $total = 0;

    public function rules()
    {
        return [
            'items.*.price' => 'required|numeric|min:1',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'items.*.price.required' => 'Price is required',
            'items.*.quantity.required' => 'Quantity is required',
            'items.*.price.min' => 'Price must be at least 1',
            'items.*.quantity.min' => 'Quantity must be at least 1',
        ];
    }

    public function addItem($id)
    {
        $product = Product::find($id);
        $index = array_search($id, array_column($this->items, "id"));
        if ($index !== false) {
            $this->items[$index]['quantity']++;
            $this->calculateTotal();
        } else {
            $this->items[] = [
                'id' => $product->id,
                'sku' => $product->sku,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'quantity' => 1,
                'sub_total' => $product->price,
            ];

            $this->calculateTotal();
        }

        $this->search = '';
        $this->searchItems = [];
    }

    public function updated($property)
    {
        $this->validate();
    }

    public function updatedItems()
    {
        $this->calculateTotal();
    }

    public function removeItem($key)
    {
        unset($this->items[$key]);
    }

    public function addPurchase()
    {
        $this->validate();
        $this->items = [];
        success_msg("Purchase created successfully.");


    }

    public function render()
    {
        if (strlen($this->search) >= 3) {
            $products = Product::where(function ($query) {
                $query->where('sku', 'LIKE', "%{$this->search}%")
                    ->orWhere('name', 'LIKE', "%{$this->search}%");
            })->select('id', 'sku', 'name', 'price', 'image')->get();

            if (count($products) === 0) {
                error_msg('No Product Found!');
            } else if (count($products) === 1) {
                $this->addItem($products[0]->id);
            } else {
                $this->searchItems = $products;
            }
        }

        return view('livewire.purchase-create');
    }

    public function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->items as $key => $item) {
            $subTotal = $item['quantity'] * $item['price'];
            $this->items[$key]['sub_total'] = $subTotal;
            $this->total += $subTotal;
        }
    }
}
