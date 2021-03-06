<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Title;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TitleController extends Controller
{
    public function index()
    {
        return view('title.index');
    }

    public function data()
    {
        $datas = Title::all();
        return DataTables::of($datas)->toJson();
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required'
        ]);

        Title::create([
            'text' => $request->text
        ]);

        return response('Data Saved');
    }

    public function edit($id)
    {
        $data = Title::find($id);
        return view('title.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => 'required'
        ]);

        Title::where('id',$id)->update([
            'text' => $request->text
        ]);

        return response('Data Updated');
    }

    public function delete($id)
    {
        Transaction::where('title_id',$id)->delete();
        Alternative::where('title_id',$id)->delete();
        Criteria::where('title_id',$id)->delete();
        $delete = Title::where('id',$id)->delete();
        return response('Data Deleted');
    }

    public function process($id)
    {
        $title = Title::find($id);
        $criterias = Criteria::orderBy('id','asc')->where('title_id',$id)->get();
        return view('process.index',compact('title','criterias'));
    }
}
