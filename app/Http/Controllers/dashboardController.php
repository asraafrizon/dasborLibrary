<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Koleksi;
use App\Inventori;
use App\Layanan;

class dashboardController extends Controller
{
	public function koleksi()
	{

		$koleksi = Koleksi::all();
		return response()->json($koleksi);
	}

	public function inventori()
	{

		$inventori = Inventori::all();
		return response()->json($inventori);
	}

	public function layanan()
	{

		$layanan = Layanan::all();
		return response()->json($layanan);
	}
}
