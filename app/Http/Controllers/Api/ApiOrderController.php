<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ApiOrderController extends ApiController
{
    public function index(){
        $category = Order::query()
        ->get()
        ->toArray();
        return $this->send_success($category);
    }

    public function select($id = 0){
        $category = Order::query()
        ->where("id", "=", $id)
        ->get()
        ->toArray()[0];
        return $this->send_success($category);
    }

    public function add(Request $request, $id = null){
        return $request->_token;
    
    }

    public function multi_add(Request $request){
        foreach($request->items as $item){
            Order::create([
                "id" => $item["id"],
                "user_id" => $item["user_id"],
                "food_id" => $item["food_id"],
                "quantity" => $item["quantity"],
                "price" => $item["price"],
                "done" => 0
            ]);
        }
        
        return $this->send_success("Your orders have been processed.");
    }

    public function edit(Request $request, $id = null){
        Order::query()
        ->where("id", "=", $id)
        ->get()
        ->take(1)
        ->update([
            "id" => $id,
            "user_id" => $request->user_id,
            "food_id" => $request->food_id,
            "quantity" => $request->quantity,
            "price" => $request->price
        ]);
        return $this->send_success("Edit complete.");
    
    }

    public function multi_edit(Request $request){
        foreach($request->items as $item){
            Order::query()
            ->where("id", "=", $item["id"])
            ->get()
            ->take(1)
            ->update([
                "id" => $item["id"],
                "user_id" => $item["user_id"],
                "food_id" => $item["food_id"],
                "quantity" => $item["quantity"],
                "price" => $item["price"]
            ]);
        }
        
        return $this->send_success("Multiple edit complete.");
    }

    public function delete($id){
        $category = Order::query()
        ->where("id", "=", $id)
        ->take(1)
        ->delete();
        return $this->send_success("Your order has been canceled");
    }

    public function multi_delete(Request $request){
        $category = Order::query()
        ->whereIn("id", "=", $request->id)
        ->delete();
        return $this->send_success("Your orders have been canceled");
    }
}
