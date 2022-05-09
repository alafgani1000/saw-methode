<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use Yajra\DataTables\Facades\DataTables;

class AlternativeController extends Controller
{
    public function index()
    {
        return view('alternative.index');
    }

    public function data($titleId)
    {
        $data = Criteria::where('title_id',$titleId)->get();
        return DataTables::of($data)->toJson();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_id' => 'required',
            'code' => 'required',
            'name' => 'required'
        ]);

        Alternative::create([
            'title_id' => $request->title_id,
            'code' => $request->code,
            'name' => $request->name
        ]);

        return response('Data Saved');
    }

    public function edit($id)
    {
        $data = Alternative::find($id);
        return view('alternative.edit',compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title_id' => 'required',
            'code' => 'required',
            'name' => 'required'
        ]);

        Alternative::where('id',$id)->update([
            'title_id' => $request->title_id,
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return response('Data Updated');
    }

    public function delete($id)
    {
        $delete = Alternative::where('id',$id)->delete();
        return response('Data Deleted');
    }
}
