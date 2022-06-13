<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Result;
use App\Models\Title;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function store(Request $req)
    {
        $criterias = Criteria::where('title_id',$req->title)->get();
        $data = collect([
            'title_id' => $req->title,
            'alternative_id' => $req->code
        ]);
        $reqArray = collect($req->all())->toArray();
        foreach ($criterias as $criteria) {
            $data->put('attribute_id',$criteria->id);
            $data->put('value',$reqArray[strtolower($criteria->id)]);
            Transaction::create($data->all());
        }
        return response("Data Saved");
    }

    public function update(Request $req)
    {
        $req->validate([
            'title' => 'required',
            'alternative' => 'required'
        ]);
        $criterias = Criteria::where('title_id',$req->title)->get();
        $reqArray = collect($req->all())->toArray();
        foreach ($criterias as $criteria) {
            Transaction::where('title_id',$req->title)
            ->where('alternative_id',$req->alternative)
            ->where('attribute_id',$criteria->id)->update([
                'value' => $reqArray[$criteria->id]
            ]);
        }
        return response("Data Updated");
    }

    public function delete($titleId,$alternativeId)
    {
        Transaction::where('title_id',$titleId)->where('alternative_id',$alternativeId)->delete();
        return response('Data Deleted');
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
        $alternatives = Alternative::where('title_id',$titleId)->whereNotIn('id',function($query) use($titleId) {
            $query->select('alternative_id')->from('transactions')->where('title_id',$titleId);
        })->get();
        $criterias = Criteria::where('title_id',$titleId)->get();
        return view('process.create',compact('alternatives','criterias','titleId'));
    }

    public function formEditTransaction($titleId,$alternativeId)
    {
        $alternatives = Alternative::where('title_id',$titleId)->where('id',$alternativeId)->first();
        $criterias = Criteria::where('title_id',$titleId)->get();
        $transactions = Transaction::where('title_id',$titleId)->where('alternative_id',$alternativeId)->get();
        return view('process.edit',compact('alternatives','criterias','titleId','transactions'));
    }

    public function data($titleId)
    {
        $criterias = Criteria::where('title_id','=',$titleId)->orderBy('id','asc')->get();
        $dataTra = Transaction::distinct()->where('title_id','=',$titleId)->get(['alternative_id']);
        $alternatives = Alternative::where('title_id','=',$titleId)->whereIn('id',$dataTra->pluck('alternative_id'))->get();
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
                'id' => $item->id,
                'code' => $item->code,
                'name' => $item->name,
                'data' => $criteria->flatMap(function ($values) {
                    return array_map('strtolower',$values);
                })
            ];
        });
        return DataTables::of($data->all())->toJson();
    }

    public function dataCrip($crips, $criteria)
    {
        $pembagi = 0;
        foreach ($crips as $crip) {
            $operator = $crip->op;
            $pembanding = $crip->end;
            $value = $crip->value;
            $cek = eval("return $criteria $operator $pembanding;");
            if ($cek == true) {
                $pembagi = $value;
            }
        }
        return $pembagi;
    }

    public function generate($titleId)
    {
        $data = collect();
        $criterias = Criteria::where('title_id',$titleId)->get();
        $alternatives = Alternative::where('title_id',$titleId)->get();
        foreach ($alternatives as $alternative) {
            $dataSub = collect();
            foreach ($criterias as $criteria) {
                if (!isset($criteria->crip)) {
                    if ($criteria->category_id == 1) { // benefit
                        $pembagi = Transaction::where('title_id',$titleId)->where('attribute_id',$criteria->id)->max('value');
                    } else if ($criteria->category_id == 2) { // cost
                        $pembagi = Transaction::where('title_id',$titleId)->where('attribute_id',$criteria->id)->min('value');
                    }
                    $ts = Transaction::where('title_id',$titleId)->where('alternative_id',$alternative->id)->where('attribute_id',$criteria->id)->first();
                    if (!is_null($ts)) {
                        if ($criteria->category_id == 1) {
                            $nilai = $ts->value /  $pembagi;
                        } else if ($criteria->category_id == 2) {
                            $nilai =  $pembagi / $ts->value;
                        }
                    } else {
                        $nilai = 0;
                    }
                    $dataSub->put($criteria->name, ($nilai * $criteria->percent));
                } else {
                    if ($criteria->category_id == 1) { // benefit
                        $dTransaction = Transaction::where('title_id',$titleId)->where('attribute_id',$criteria->id)->max('value');
                    } else if ($criteria->category_id == 2) { // cost
                        $dTransaction = Transaction::where('title_id',$titleId)->where('attribute_id',$criteria->id)->min('value');
                    }
                    $ts = Transaction::where('title_id',$titleId)->where('alternative_id',$alternative->id)->where('attribute_id',$criteria->id)->first();
                    $crips = json_decode($criteria->crip->data_crips);

                    $pembagi = $this->dataCrip($crips, $dTransaction);
                    if (!is_null($ts)) {
                        $nilaiCriteria = $this->dataCrip($crips, $ts->value);
                        if ($criteria->category_id == 1) {
                            $nilai = $nilaiCriteria /  $pembagi;
                        } else if ($criteria->category_id == 2) {
                            $nilai =  $pembagi / $nilaiCriteria;
                        }
                    } else {
                        $nilai = 0;
                    }
                    $dataSub->put($criteria->name, ($nilai * $criteria->percent));
                }
            }
            $total = $dataSub->sum();
            $dataSub->put('alternative_id',$alternative->id);
            $dataSub->put('total',$total);
            $data->push($dataSub);
        };
        foreach($data->all() as $item) {
            $result = Result::where('alternative_id', $item['alternative_id'])->first();
            if (!is_null($result)) {
                $result->delete();
            }
            Result::create([
                'alternative_id' => $item['alternative_id'],
                'result' => $item['total']
            ]);
        }
        // return $data;
        return ('Generate Success');
    }

    public function dataResult($titleId)
    {
        $data = Alternative::with('result')->get();
        return DataTables::of($data)->toJson();
    }
}
