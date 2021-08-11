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
        //check if tool exist in request form
        if($this->items) {
            if(array_key_exists($id, $this->items)){
                $storeItem = $this->items[$id];
                
            }
        }
        $storeItem['qty']++;
        $this->items[$id] = $storeItem;
        $this->totalQty++;
    }
    public function updateRequest($id, $qty) 
    {
        //dd($this->items[$id]['qty']);
        //delete current quanity of tool in request
        $this->totalQty = $this->totalQty - $this->items[$id]['qty'];
        //update quanity of tool in request
        $this->items[$id]['qty'] = $qty;
        //update total quanity 
        $this->totalQty = $this->totalQty + $this->items[$id]['qty'];
    }
    public function remove($id)
    {
        // decrease quanity
        $this->totalQty = $this->totalQty - $this->items[$id]['qty'];
        //remove in session
        unset($this->items[$id]);

    }
}
