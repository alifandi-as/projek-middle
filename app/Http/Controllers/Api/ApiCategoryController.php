<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ApiCategoryController extends ApiController
{
    public function index(){
        $category = Category::query()
        ->get()
        ->toArray();
        return $this->send_success($category);
    }

    public function select($id = 0){
        $category = Category::query()
        ->where("id", "=", $id)
        ->get()
        ->toArray()[0];
        return $this->send_success($category);
    }

    public function add(Request $request, $id = null){
        Category::create([
            "id" => $id,
            "category" => $request->category,
            "image" => $request->image
        ]);
        return $this->send_success("Add complete.");
    
    }

    public function multi_add(Request $request){
        foreach($request->items as $item){
            Category::create([
                "id" => $item["id"],
                "category" => $item["category"],
                "image" => $item["image"]
            ]);
        }
        
        return $this->send_success("Multiple add complete.");
    }

    public function edit(Request $request, $id = null){
        Category::query()
        ->where("id", "=", $id)
        ->get()
        ->take(1)
        ->update([
            "id" => $id,
            "category" => $request->category,
            "image" => $request->image
        ]);
        return $this->send_success("Edit complete.");
    
    }

    public function multi_edit(Request $request){
        foreach($request->items as $item){
            Category::query()
            ->where("id", "=", $item["id"])
            ->get()
            ->take(1)
            ->update([
                "id" => $item["id"],
                "category" => $item["category"],
                "image" => $item["image"]
            ]);
        }
        
        return $this->send_success("Multiple edit complete.");
    }

    public function delete($id){
        $category = Category::query()
        ->where("id", "=", $id)
        ->take(1)
        ->delete();
        return $this->send_success("Category id {$id} has been deleted");
    }

    public function multi_delete(Request $request){
        $category = Category::query()
        ->whereIn("id", "=", $request->id)
        ->delete();
        return $this->send_success("Category id {$request->id} has been deleted");
    }
}
