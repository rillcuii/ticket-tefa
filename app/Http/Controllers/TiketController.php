<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class tiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datatiket = tiket::orderBy('nama','asc')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Data Di temukan',
            'ticket' => $datatiket
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datatiket = new tiket();
        $rules = [
            'nama' => 'required',
            'instansi' => 'required',
            'email' => 'required',
            'no_telp' => 'required',
            'judul_keluhan' => 'required',
            'ket_keluhan' => 'required',
            'sebab' => 'required',
            'tgl_pembuatan' => 'required',
            'tgl_expired' => 'required',
            'catatan_kaki' => 'required',
            'id_prioritas' => 'required',
            'id_status' => 'required',
            'bukti' => 'required',
            'nama_pic' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json([
                'status' =>false,
                'message'=>'gagal memasukan data',
                'data' => $validator->errors()
            ], 401);
        }
        $datatiket->nama = $request->nama;
        $datatiket->instansi = $request->instansi;
        $datatiket->email = $request->email;
        $datatiket->no_telp = $request->no_telp;
        $datatiket->judul_keluhan = $request->judul_keluhan;
        $datatiket->ket_keluhan = $request->ket_keluhan;
        $datatiket->sebab = $request->sebab;
        $datatiket->tgl_pembuatan = $request->tgl_pembuatan;
        $datatiket->tgl_expired = $request->tgl_expired;
        $datatiket->catatan_kaki = $request->catatan_kaki;
        $datatiket->id_prioritas = $request->id_prioritas;
        $datatiket->id_status = $request->id_status;
        $datatiket->bukti = $request->bukti;
        $datatiket->nama_pic = $request->nama_pic;

        $datatiket->save();

        return response()->json([
            'status'=>true,
            'message'=>'berhasil menambahkan data'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tiket $tiket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tiket $tiket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tiket $tiket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tiket $tiket)
    {
        //
    }
}
