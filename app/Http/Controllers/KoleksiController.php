<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Koleksi;
use Yajra\DataTables\DataTables;
use Mockery\Exception;
use Excel;

class KoleksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('koleksi');
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

        Koleksi::create($input);
        return response()->json([
            'success' => true,
            'message' => 'Data koleksi ditambahkan'
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
        $koleksi = Koleksi::findOrFail($id);
        return $koleksi;
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
        $koleksi = Koleksi::findOrFail($id);

        $koleksi->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data koleksi diupdate'
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
        Koleksi::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data koleksi dihapus'
        ]);
    }

    public function apiKoleksi()
    {
        $koleksi = Koleksi::all();

        return DataTables::of($koleksi)
        ->addColumn('action', function($koleksi) {
            return 
            // '<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show </a> '.
            '<a onclick="editForm('.$koleksi->id.')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit </a> '.
            '<a onclick="deleteData('.$koleksi->id.')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete </a> ';
        })
        ->rawColumns(['action'])->make(true);
    }

    public function koleksiExport()
    {
      $koleksi = Koleksi::select('jurnal', 'tahun', 'jumlah')->get();
      return Excel::create('data_koleksi', function($excel) use ($koleksi) {
        $excel->sheet('mysheet', function($sheet) use ($koleksi) {
            $sheet->fromArray($koleksi);
        });
    })->download('xlsx');

  }

  public function koleksiImport(Request $request){
    if($request->hasFile('file')){
        $path = $request->file('file')->getRealPath();
        $data = Excel::load($path, function($reader){})->get();
        if(!empty($data) && $data->count()){
            Koleksi::truncate();
            foreach ($data as $key => $value) {
                $koleksi = new Koleksi();
                $koleksi->jurnal = $value->jurnal;
                $koleksi->tahun = $value->tahun;
                $koleksi->jumlah = $value->jumlah;
                $koleksi->save();
            }
        }
    }

    return back();
}
}
