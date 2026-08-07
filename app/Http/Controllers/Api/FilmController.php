<?php

namespace App\Http\Controllers\Api;

use App\Models\Film;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;

class FilmController extends Controller
{
    public function index()
        {
            try {
                $film = Film::with(['genre','aktors'])->get();

                return response()->json([
                    'status' => true,
                    'message'=> 'Data film berhasil diambil.',
                    'data'=> $film
                ],200);

            } catch(Exception $e) {
                 
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],500);
            }
        }
    
        public function store(Request $request)
        {
            try {
                $request->validate([
                'judul' => 'required|string',
                'durasi'=>'required|integer',
                'rating'=> 'required|numeric',
                'desc'=>'required',
                'tahun_rilis'=>'required|date',
                'poster'=>'required|string',
                'sutradara'=>'required|string',
                'id_aktor'=>'required|array',
                'id_aktor.*'=>'exists:aktors,id'
                ]);

                $film = new Film();
                
                $film->judul = $request->judul;
                $film->durasi = $request->durasi;
                $film->rating = $request->rating;
                $film->desc = $request->desc;
                $film->tahun_rilis = $request->tahun_rilis;
                $film->poster = $request->poster;
                $film->sutradara = $request->sutradara;
                $film->genre_id = $request->genre_id;

                $film->save();

                $film->aktors()->attach($request->id_aktor);

                return response()->json([
                 'status'=>true,
                 'message'=>'Film berhasil ditambahkan.',
                 'data'=>$film->load('genre','aktors')
        ],201);

            }  catch(Exception $e){

        return response()->json([
            'status'=>false,
            'message'=>$e->getMessage()
        ],500);
        }
    }

    public function show($id)
    {
        try {

        $film = Film::with(['genres','aktors'])->find($id);

        if(!$film){

        return response()->json([
            'status'=>false,
            'message'=>'Film tidak ditemukan.'
        ],404);

        }

 } catch(Exception $e) {

        return response()->json([
            'status'=>false,
            'message'=>$e->getMessage()
        ],500);

        }
    }
    public function update(Request $request,$id)
{
    try {

        $film = Film::find($id);

        if(!$film){

            return response()->json([
                'status'=>false,
                'message'=>'Film tidak ditemukan.'
            ],404);

        }

        $request->validate([
            'judul' => 'required|string',
            'durasi'=>'required|integer',   
            'rating'=> 'required|numeric',
            'desc'=>'required',
            'tahun_rilis'=>'required|date',
            'poster'=>'required|string',
            'sutradara'=>'required|string',
            'id_aktor'=>'required|array',
            'id_aktor.*'=>'exists:aktors,id'
        ]);

        $film->judul = $request->judul;
        $film->tahun_rilis = $request->tahun_rilis;
        $film->durasi = $request->durasi;
        $film->desc = $request->desc;
        $film->genre_id = $request->genre_id;
        $film->poster = $request->poster;
        $film->sutradara = $request->sutradara;

        $film->save();

        $film->aktors()->sync($request->id_aktor);

        return response()->json([
            'status'=>true,
            'message'=>'Film berhasil diperbarui.',
            'data'=>$film->load('genre','aktors')
        ]);

    } catch(Exception $e){

        return response()->json([
            'status'=>false,
            'message'=>$e->getMessage()
        ],500);

    }
}

public function destroy($id)
{
    try {

        $film = Film::find($id);

        if(!$film){

            return response()->json([
                'status'=>false,
                'message'=>'Film tidak ditemukan.'
            ],404);

        }

        $film->aktors()->detach();

        $film->delete();

        return response()->json([
            'status'=>true,
            'message'=>'Film berhasil dihapus.'
        ]);

    } catch(Exception $e){

        return response()->json([
            'status'=>false,
            'message'=>$e->getMessage()
        ],500);

    }
}
}