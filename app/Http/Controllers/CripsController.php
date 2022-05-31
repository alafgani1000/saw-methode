<?php

namespace App\Http\Controllers;

use App\Models\Crip;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CripsController extends Controller
{
    public function create($titleId)
    {
        $criteria = Criteria::where('title_id',$titleId)->whereNotIn('id', function ($query) {
            $query->select('criteria_id')->from('crips');
        })
        ->get();
        return view('crips.create',compact('criteria'));
    }

    public function data($titleId)
    {
        $data = Crip::with(['criteria' => function ($query) use($titleId) {
            $query->where('title_id',$titleId);
        }])
        ->get();
        return DataTables::of($data)->toJson();
    }

    public function store(Request $req)
    {
        $req->validate([
            'criteria' => 'required',
            'end.*' => 'required|numeric',
            'operator.*' => 'required|string',
            'value.*' => 'required|numeric'
        ]);
        $crips = collect();
        $startCount = count($req->end);
        for($i = 0; $i < $startCount; $i++) {
            $crips->push([
                'op' => $req->operator[$i],
                'end' => $req->end[$i],
                'value' => $req->value[$i]
            ]);
        }
        Crip::create([
            'criteria_id' => $req->criteria,
            'data_crips' => $crips
        ]);
        return response("Data Saved");
    }

    public function edit($id)
    {
        $crip = Crip::with('criteria')->where('id',$id)->first();
        return view('crips.edit', compact('crip'));
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'datacrips' => 'required'
        ]);
        Crip::where('id',$id)->update([
            'data_crips' => $req->datacrips
        ]);
        return response("Data Updated");
    }

    public function delete($id)
    {
        Crip::where('id',$id)->delete();
        return response("Data Deleted");
    }
}
