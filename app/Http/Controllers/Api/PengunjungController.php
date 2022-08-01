<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengunjung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengunjungController extends Controller
{
    public function index()
    {
        $data = Pengunjung::all();

        if ($data->count() > 0) {
            return response()->json([
                'status' => 'success',
                'message' => 'List Data Pengunjung',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Pengunjung Kosong',
            ]);
        }

    }

    public function show($id)
    {
        $data = Pengunjung::findOrFail($id);

        if ($data) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data Pengunjung berdasarkan id ' . $id,
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Pengunjung tidak ditemukan',
            ], 404);
        }

    }

    public function destroy($id)
    {
        $data = Pengunjung::findOrFail($id);
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
            'nama_pengunjung' => 'required'
            , 'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'no_telp' => 'required',
            'no_ktp' => 'required'
        ]);
        if ($validate->passes()) {
            $data = Pengunjung::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Data Pengunjung Berhasil Ditambahkan',
                'data' => $data,
            ]);

        }
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Pengunjung Tidak Berhasil Ditambahkan',
            ], 400);
        }

    }
    public function update(Request $request, $id)
    {

        $data = Pengunjung::findOrfail($id);

        if (!empty($data)) {
            $validate = Validator::make($request->all(), [
                'nama_pengunjung' => 'required',
                'alamat'          => 'required',
                'jenis_kelamin'   => 'required',
                'no_telp'         => 'required',
                'no_ktp'          => 'required'
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
