<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::when(request()->q, function($query) {
            $query->where("name", "LIKE", "%".\request()->q."%");
        })
        ->latest()
        ->paginate(10);

        return Inertia::render("Apps/Categories/Index", [
            "categories" => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Apps/Categories/Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2000',
            'name'  => 'required|string|unique:categories',
            'description' => 'required|string'
        ]);

        $image = $request->file("image");
        $image_name = $image->hashName();
        $image->move("images/categories", $image_name);
        
        Category::create([
            'image'         => $image_name,
            'name'          => $request->name,
            'description'   => $request->description
        ]);

        return redirect()->route('apps.categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return Inertia::render('Apps/Categories/Edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name'          => 'required|unique:categories,name,'.$category->id,
            'description'   => 'required',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2000'
        ]);

        if ($request->hasFile("image")) {
            if (\file_exists("./images/categories/" . \basename($category->image))) {
                \unlink("./images/categories/" . \basename($category->image));
            }

            $image = $request->file("image");
            $image_name = $image->hashName();
            $image->move("images/categories", $image_name);
        } else {
            $image_name = \basename($category->image);
        }

        $category->update([
            'image'=> $image_name,
            'name' => $request->name,
            'description'   => $request->description
        ]);

        return redirect()->route('apps.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        \unlink("./images/categories/" . \basename($category->image));
        $category->delete();
        return redirect()->route('apps.categories.index');
    }
}
