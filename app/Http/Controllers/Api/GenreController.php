<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(){
        try {
            $genres = Genre::latest()->get();
            return response()->json([
                'status' => true,
                'message' => "data genre berhasil diambil",
                'data' => $genres,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => true,
                'message' => $e->getmessage(),
            ], 500);
        }
    }
    
    public function store(Request $request){
        try{
           $request->validate([
                'nama_genre'=> 'required|unique:genres,nama_genre',
            ]);
            $genre = new Genre();
            $genre->nama_genre = $request->nama_genre;
            $genre->slug = Str::slug($request->nama_genre) . Str::random(10);
            $genre->save();

            return response()->json([
                'status' => true,
                'message' => 'data genre berhasil dibuat',
                'data' => $genre
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getmessage(),
            ], 500);
        }
    }
    public function update(Request $request, $id){
         try{

            $genre = Genre::find($id);
            if(!$genre) {
                return response()->json([
                    'status' => false,
                    'message' => 'data genre tidak ada',
                ], 404);
            }
            $request->validate([
                'nama_genre' => 'required|unique:genres,nama_genre,' . $id,
            ]);
            $genre->nama_genre = $request->nama_genre;
            $genre->slug = Str::slug($request->nama_genre) . Str::random(10);
            $genre->save();

            return response()->json([
                'status' => true,
                'message' => 'data genre berhasil diedit',
                'data' => $genre
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getmessage(),
            ], 500);
        }
    }

    public function destroy($id){
        try {
            $genre = Genre::find($id);

            if (! $genre) {
                return response()->json([
                    'status' =>false,
                    'message' => 'data genre tidak ditemukan',
                ], 404);
            }
            $genre->delete();
            return response()->json([
                'status'=>true,
                'message'=>'data genre berhasil dihapus',
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],500);
              }
        }
}