<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function store(Request $req)
    {
        $data = collect([
            'title_id' => $req->titleId,
            'alternative_id' => $req->alternativeId
        ]);
        $criterias = Criteria::where('title_id',$req->title_id)->get();
        $reqArray = collect($req->all())->toArray();
        foreach ($criterias as $criteria) {
            $data->put('attribute_id',$criteria->id);
            $data->put('value',$req[$criteria->name]);
            Transaction::create($data);
        }
    }

    public function columTransaction($titleId)
    {
        $criterias = Criteria::orderBy('id','asc')->where('title_id',$titleId)->get();
        $crt = $criterias->map(function ($item,$key) {
            return [
                'data' => 'data.'.$item->name
            ];
        })->all();
        $alter = collect([
            ['data' => 'code'],
            ['data' => 'name']
        ]);
        $column = $alter->merge($crt);
        return response()->json($column);
    }

    public function formTransaction($titleId)
    {
        $alternatives = Alternative::where('title_id',$titleId)->whereNotIn('code',function($query) use($titleId) {
            $query->select('code')->from('transactions')->where('title_id',$titleId);
        })->get();
        $criterias = Criteria::where('title_id',$titleId);
        return view('process.create',compact('alternatives','criterias'));
    }

    public function data($titleId)
    {
        $criterias = Criteria::where('title_id','=',$titleId)->orderBy('id','asc')->get();
        $alternatives = Alternative::where('title_id','=',$titleId)->get();
        $datas = Transaction::where('title_id','=',$titleId)->get();
        $data = $alternatives->map(function($item, $key) use($criterias,$datas,$titleId) {
            $alternativeId = $item->id;
            $criteria = $criterias->map(function($item, $key) use($datas,$titleId,$alternativeId) {
                $value = $datas->where('attribute_id','=',$item->id)->where('title_id','=',$titleId)->where('alternative_id','=',$alternativeId)->first();
                return [
                    $item->name => isset($value->value) ? $value->value : '0'
                ];
            });
            // return
            return [
                'code' => $item->code,
                'name' => $item->name,
                'data' => $criteria->flatMap(function ($values) {
                    return array_map('strtolower',$values);
                })
            ];
        });
        return DataTables::of($data->all())->toJson();
    }

    public function generate($titleId)
    {
        $data = collect();
        $criterias = Criteria::where('title_id',$titleId)->get();
        $alternatives = Alternative::where('title_id',$titleId)->get();
        foreach ($alternatives as $alternative) {
            $dataSub = collect();
            foreach ($criterias as $criteria) {
                if ($criteria->category_id == 1) { // benefit
                    $pembagi = Transaction::where('title_id',$titleId)->where('attribute_id',$criteria->id)->max('value');
                }
                if ($criteria->category_id == 2) { // benefit
                    $pembagi = Transaction::where('title_id',$titleId)->where('attribute_id',$criteria->id)->min('value');
                }
                $ts = Transaction::where('title_id',$titleId)->where('alternative_id',$alternative->id)->where('attribute_id',$criteria->id)->first();
                if (!is_null($ts)) {
                    $nilai = $ts->value /  $pembagi;
                } else {
                    $nilai = 0;
                }
                $dataSub->put($criteria->name, ($nilai * $criteria->percent));
            }
            $data->push($dataSub);
        };
        return $data;
    }
}
