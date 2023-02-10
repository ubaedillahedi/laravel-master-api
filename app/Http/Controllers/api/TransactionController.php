<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $result = DB::table('transactions')->get();
        return response([
            'status' => true,
            'message' => 'Success',
            'data' => $result->toArray()
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'amount' => 'required',
            'type' => 'required',
            'time' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'status' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $req = $request->all();
        $data = $request->only(['title', 'amount', 'type']);
        $data['created_at'] = date('Y-m-d H:i:s', strtotime($req['time']));
        $result = DB::table('transactions')->insert($data);
        return response([
            'status' => true,
            'message' => 'Success',
            'data' => $result
        ], 200);
    }

    public function change(Request $request, $id = null)
    {
        $req = $request->all();
        $data = $request->only(['title', 'amount', 'type']);
        $data['created_at'] = date('Y-m-d H:i:s', strtotime($req['time']));
        $result = DB::table('transactions')->where('id', $id)->update($data);
        return response([
            'status' => true,
            'message' => 'Success',
            'data' => $result
        ], 200);
    }
}
