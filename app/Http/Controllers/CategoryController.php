<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index');
    }

    public function data()
    {
        $datas = Categories::all();
        return view('category.data', compact('datas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Categories::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response('Data saved');
    }

    public function edit($id)
    {
        $data = Categories::find($id);
        return view('category.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $update = Categories::where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response('Data Updated');
    }

    public function delete($id)
    {
        $delete = Categories::where('id',$id)->delete();
        return response('Data Deleted');
    }
}
