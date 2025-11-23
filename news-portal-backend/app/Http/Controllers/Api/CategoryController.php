<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller {
    public function index(){ return response()->json(Category::all()); }
    public function show(Category $category){ return response()->json($category); }

    public function store(Request $req){
        $data = $req->validate(['name'=>'required|string|unique:categories,name']);
        $data['slug'] = Str::slug($data['name']);
        $cat = Category::create($data);
        return response()->json($cat,201);
    }

    public function update(Request $req, Category $category){
        $data = $req->validate(['name'=>'required|string|unique:categories,name,'.$category->id]);
        $data['slug'] = Str::slug($data['name']);
        $category->update($data);
        return response()->json($category);
    }

    public function destroy(Category $category){
        $category->delete();
        return response()->json(['message'=>'deleted']);
    }
}
