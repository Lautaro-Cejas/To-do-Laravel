<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'color' => 'required|max:7'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->color = $request->color;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Nueva categoria agregada!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        return view('categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->name;
        $category->color = $request->color;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Categoria actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->todos()->each(function ($todo) {
            $todo->delete();
        });
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoria eliminada con éxito!');
    }
}
