<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasFactory;
    public $items = null;
    public $totalQty = 0;

    public function __construct($oldRequest)
    {
        if($oldRequest) {
            $this->items = $oldRequest->items;
            $this->totalQty = $oldRequest->totalQty;
        }
    }
    public function add($item, $id)
    {
        $storeItem = [
            'item' => $item,
            'qty' => 0
        ];
        if($this->items) {
            if(array_key_exists($id, $this->items)){
                $storeItem = $this->items[$id];
            }
        }
        $storeItem['qty']++;
        $this->items[$id] = $storeItem;
        $this->totalQty++;
    }
    public function store($id, $qty) 
    {
        //dd($this->items[$id]['qty']);
    
        $this->totalQty = $this->totalQty - $this->items[$id]['qty'];
        
        $this->items[$id]['qty'] = $qty;

        $this->totalQty = $this->totalQty + $this->items[$id]['qty'];
    }
    public function remove($id)
    {
        // trừ bớt số lượng
        $this->totalQty = $this->totalQty - $this->items[$id]['qty'];

        unset($this->items[$id]);

    }
}
