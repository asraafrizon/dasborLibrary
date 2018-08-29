<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Layanan;
use Yajra\DataTables\DataTables;
use Mockery\Exception;
use Excel;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layanan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        Layanan::create($input);
        return response()->json([
            'success' => true,
            'message' => 'Data layanan ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);
        return $layanan;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $layanan = Layanan::findOrFail($id);
        $layanan->update();

        return response()->json([
            'success' => true,
            'message' => 'Data layanan diupdate'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Layanan::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function apiLayanan()
    {
        $layanan = Layanan::all();
        return DataTables::of($layanan)
        ->addColumn('action', function($layanan) {
            return 
            // '<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show </a> '.
            '<a onclick="editForm('.$layanan->id.')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit </a> '.
            '<a onclick="deleteData('.$layanan->id.')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete </a> ';
        })
        ->rawColumns(['action'])->make(true);
    }

        public function layananExport()
    {
        $layanan = Layanan::select('aktivitas', 'tahun', 'data_layanan')->get();
        return Excel::create('data_layanan', function($excel) use ($layanan) {
            $excel->sheet('mysheet', function($sheet) use ($layanan) {
                $sheet->fromArray($layanan);
            });
        })->download('xlsx');
    }

    public function layananImport(Request $request)
    {
        if($request->hasFile('file')){
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function($reader){})->get();
            if(!empty($data) && $data->count()){
                Layanan::truncate();
                foreach ($data as $key => $value) {
                    $layanan = new Layanan();
                    $layanan->aktivitas = $value->aktivitas;
                    $layanan->tahun = $value->tahun;
                    $layanan->data_layanan = $value->data_layanan;
                    $layanan->save();
                }
            }
        }

        return back();
    }
}
