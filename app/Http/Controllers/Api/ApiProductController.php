<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\CategoryLink;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ApiProductController extends ApiController
{
    public function index(){
        $product = Product::query()
        ->get()
        ->toArray();
        return $this->send_success($product);
    }

    public function select($id = 0){
        $product = Product::query()
        ->where("id", "=", $id)
        ->get()
        ->toArray()[0];
        return $this->send_success($product);
    }

    public function add(Request $request, $id = null){
        Product::create([
            "id" => $id,
            "name" => $request->name,
            "image" => $request->image,
            "description" => $request->description,
            "price" => $request->price,
            "piece" => $request->piece,
            "category_id" => $request->category_id
        ]);

        // foreach($request->category_ids as $category_id)
        // {
        //     CategoryLink::create([
        //         "food_id" => $id,
        //         "category_id" => $category_id
        //     ]);
        // }
        return $this->send_success("Add complete.");
    
    }

    public function multi_add(Request $request){
        foreach($request->items as $item){
            Product::create([
                "id" => $item["id"],
                "name" => $item["name"],
                "image" => $item["image"],
                "description" => $item["description"],
                "price" => $item["price"],
                "category_id" => $request->category_id
            ]);
            // foreach($item["category_ids"] as $category_id)
            // {
            //     CategoryLink::create([
            //         "food_id" => $item["id"],
            //         "category" => $category_id
            //     ]);
            // }
        }
        
        return $this->send_success("Multiple add complete.");
    }

    public function edit(Request $request, $id = null){
        Product::query()
        ->where("id", "=", $id)
        ->take(1)
        ->update([
            "id" => $id,
            "name" => $request->name,
            "image" => $request->image,
            "description" => $request->description,
            "price" => $request->price,
            "category_id" => $request->category_id
        ]);
        return $this->send_success("Edit complete.");
    
    }

    public function multi_edit(Request $request){
        foreach($request->items as $item){
            Product::query()
            ->where("id", "=", $item["id"])
            ->get()
            ->take(1)
            ->update([
                "id" => $item["id"],
                "name" => $item["name"],
                "image" => $item["image"],
                "description" => $item["description"],
                "price" => $item["price"],
                "category_id" => $request->category_id
            ]);
        }
        
        return $this->send_success("Multiple edit complete.");
    }

    public function delete($id){
        $product = Product::query()
        ->where("id", "=", $id)
        ->take(1)
        ->delete();
        return $this->send_success("Product id {$id} has been deleted");
    }

    public function multi_delete(Request $request){
        $product = Product::query()
        ->whereIn("id", "=", $request->id)
        ->delete();
        return $this->send_success("Product id {$request->id} has been deleted");
    }
}
