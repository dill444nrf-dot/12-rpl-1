<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PublicController extends Controller
{
    public function films() {
        try {
        $films = DB::table('films')
        ->join('genres','films.genre_id','=','genres.id')
        ->select(
            'films.id',
            'films.judul',
            'films.durasi',
            'films.rating',
            'films.desc',
            'films.tahun_rilis',
            'films.poster',
            'films.sutradara',
            'genres.nama_genre'
        )
        ->orderBy('films.id','desc')
        ->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Data film berhasil diambil.',
            'data'=>$films
        ], 200);

        } catch (Exception $e) {
             return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
        }
    }
}
