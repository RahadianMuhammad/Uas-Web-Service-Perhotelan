<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KamarController extends Controller
{
    public function index()
    {
        $data = Kamar::all();

        if ($data->count() > 0) {
            return response()->json([
                'status' => 'success',
                'message' => 'List Data Kamar',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Kamar Kosong',
            ]);
        }


    }
    public function show($id)
    {
        $data = Kamar::findOrFail($id);

        if (!empty($data)) {
            return $data;
        }
        return response()->json(['message' => 'data tidak ditemukan'], 404);
    }
    public function destroy($id)
    {
        $data = Kamar::findOrFail($id);

        if (empty($data)) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        $data->delete();
        return response()->json([

            'message' => 'data berhasil dihapus'
        ], 200);
    }
    public function store(Request $request )
    {

        $validate = Validator::make($request->all(), [
            'jenis_kamar' => 'required',
            'harga' => 'required'
        ]);
        if ($validate->passes()) {
            $data = Kamar::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Data Kamar Berhasil Ditambahkan',
                'data' => $data,
            ]);

        }
        return response()->json(['message' => 'Data Gagal Disimpan']);
    }

    public function update(Request $request, $id)
    {

        $data = Kamar::findOrFail($id);

        if (!empty($data)) {
            $validate = Validator::make($request->all(), [
                'jenis_kamar' => 'required',
                'harga' => 'required'
            ]);
            if ($validate->passes()) {
                $data->update($request->all());

                return response()->json(['message' => 'Data berhasil di update',
                    'data' => $data ]);
            } else {
                return response()->json(['message' => 'data tidak ditemukan',
                    'data' => $validate->errors()->all()]);
            }
        }
        return response()->json(['message' => 'data tidak ditemukan'], 404);
    }
}
