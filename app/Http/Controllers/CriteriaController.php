<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function index($titleId)
    {
        $datas = Criteria::where('title_id',$titleId)->get();
        return view('criteria.index', compact('datas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_id' => 'required',
            'name' => 'required',
            'category' => 'required',
            'percent' => 'required'
        ]);

        Criteria::create([
            'title_id' => $request->title_id,
            'name' => $request->name,
            'category_id' => $request->category,
            'percent' => $request->percent
        ]);

        return response('Data Saved');
    }

    public function edit($id)
    {
        $data = Criteria::find($id);
        return view('criteria.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title_id' => 'required',
            'name' => 'required',
            'category_id' => 'required',
            'percent' => 'required'
        ]);

        Criteria::where('id',$id)->update([
            'title_id' => $request->title_id,
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
