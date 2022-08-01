<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function index()
    {
        $data = Karyawan::all();

        if ($data->count() > 0) {
            return response()->json([
                'status' => 'success',
                'message' => 'List Data Karyawan',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Karyawan Kosong',
            ]);
        }

    }

    public function show($id)
    {
        $data = Karyawan::findOrFail($id);

        if ($data) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data Karyawan berdasarkan id ' . $id,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Karyawan tidak ditemukan',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $data = Karyawan::findOrFail($id);

        if (empty($data)) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
        $data->delete();
        return response()->json([
            'message' => 'data berhasil dihapus'
        ], 200);
    }

    public function store( Request $request)
    {

        $validate = Validator::make($request->all(), [
            'nama_karyawan' => 'required',
            'jenis_kelamin' => 'required'
        ]);
        if ($validate->passes()) {

            $data = Karyawan::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Data Karyawan Berhasil Ditambahkan',
                'data' => $data,
            ]);


        }
        return response()->json(['message' => 'Data Gagal Disimpan'], 400);
    }

    public function update(Request $request, $id)
    {

        $data = Karyawan::findOrFail($id);

        if (!empty($data)) {
            $validate = Validator::make($request->all(), [
                'nama_karyawan' => 'required',
                'jenis_kelamin' => 'required'
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
