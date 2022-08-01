<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = Transaksi::with('pengunjung','karyawan')->get();

        if ($data->count() > 0) {
            return response()->json([
                'status' => 'success',
                'message' => 'List Data Transaksi',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Transaksi Kosong',
            ]);
        }

    }
    public function show($id)
    {
        $data = Transaksi::findOrFail($id);

        if ($data) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data Transaksi berdasarkan id ' . $id,
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Transaksi tidak ditemukan',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $data = Transaksi::findOrFail($id);

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
            'id_pengunjung' => 'required',
            'id_karyawan' => 'required',
            'jumlah_kamar' => 'required',
            'tanggal_masuk' => 'required',
            'lama_nginap' => 'required',
            'total_harga' => 'required'
        ]);
        if ($validate->passes()) {
            $data = transaksi::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Data Transaksi Berhasil Ditambahkan',
                'data' => $data,
            ]);

        }
        return response()->json(['message' => 'Data Gagal Disimpan']);

    }

    public function update(Request $request, $id)
    {

        $data = Transaksi::findOrFail($id);

        if (!empty($data)) {
            $validate = Validator::make($request->all(), [
                'id_pengunjung' => 'required',
                'id_karyawan' => 'required',
                'jumlah_kamar' => 'required',
                'tanggal_masuk' => 'required',
                'lama_nginap' => 'required',
                'total_harga' => 'required'
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
