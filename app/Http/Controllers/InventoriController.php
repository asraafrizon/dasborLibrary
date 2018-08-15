<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventori;
use Yajra\DataTables\DataTables;
use Mockery\Exception;
use Excel;
use Validator;

class InventoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventori');
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

        Inventori::create($input);
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
        $inventori = Inventori::findOrFail($id);
        return $inventori;
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
        $inventori = Inventori::findOrFail($id);

        $inventori->update($input);
        return response()->json([
            'success' => true,
            'message' => 'Data Inventori diupdate'
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
        Inventori::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data inventori dihapus'
        ]);
    }

    public function apiInventori()
    {
        $inventori = Inventori::all();
        return DataTables::of($inventori)
        ->addColumn('action', function($inventori) {
            return 
            // '<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show </a> '.
            '<a onclick="editForm('.$inventori->id.')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit </a> '.
            '<a onclick="deleteData('.$inventori->id.')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete </a> ';
        })
        ->rawColumns(['action'])->make(true);
    }

    public function inventoriExport()
    {
      $inventori = Inventori::select('tahun', 'fakultas', 'data_judul','data_eksemplar')->get();
      return Excel::create('data_inventori', function($excel) use ($inventori) {
        $excel->sheet('mysheet', function($sheet) use ($inventori) {
            $sheet->fromArray($inventori);
        });
    })->download('xlsx');

  }

  public function inventoriImport(Request $request)
  {
    

    if($request->hasFile('file'))
    {
        $path = $request->file('file')->getRealPath();
        $data = Excel::load($path, function($reader){})->get();
        if(!empty($data) && $data->count())
        {
            foreach ($data as $key => $value) {
                $inventori = new Inventori();
                $inventori->tahun = $value->tahun;
                $inventori->fakultas = $value->fakultas;
                $inventori->data_judul = $value->data_judul;
                $inventori->data_eksemplar = $value->data_eksemplar;
                $inventori->save();

            }

        }

    }
    return back();
}


}
