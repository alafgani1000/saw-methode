<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function data($titleId)
    {
        $criterias = Criteria::where('title_id','=',$titleId)->get();
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
        return DataTables::of($data->all());
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
