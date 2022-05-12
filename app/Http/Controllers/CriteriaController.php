<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CriteriaController extends Controller
{
    public function data($titleId)
    {
        $datas = Criteria::with('category')->where('title_id',$titleId)->get();
        return DataTables::of($datas)->toJson();
    }

    public function create($titleId)
    {
        $categories = Categories::all();
        $title_id = $titleId;
        return view('criteria.create',compact('categories','title_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'name' => 'required',
            'category' => 'required',
            'percent' => 'required'
        ]);

        Criteria::create([
            'title_id' => $request->title,
            'name' => $request->name,
            'category_id' => $request->category,
            'percent' => $request->percent
        ]);

        return response('Data Saved');
    }

    public function edit($id)
    {
        $data = Criteria::find($id);
        $categories = Categories::all();
        return view('criteria.edit', compact('data','categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'name' => 'required',
            'category' => 'required',
            'percent' => 'required'
        ]);

        Criteria::where('id',$id)->update([
            'title_id' => $request->title,
            'name' => $request->name,
            'category_id' => $request->category,
            'percent' => $request->percent
        ]);

        return response('Data Updated');
    }

    public function delete($id)
    {
        $delete = Criteria::where('id',$id)->delete();
        return response('Data Deleted');
    }
}
