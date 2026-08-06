<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aktor;
use Exception;
use Illuminate\Http\Request;

class AktorController extends Controller
{
     public function index(){
        try {
            $aktors = Aktor::latest()->get();
            return response()->json([
                'status' => true,
                'message' => "data Aktor berhasil diambil",
                'data' => $aktors,
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
                'nama_aktor'=> 'required|max:255',
                'gender' => 'required|in:laki-laki,perempuan',
                'umur'=>'required|integer',
                'foto'=>'required'
            ]);
            $aktor = new Aktor();
            $aktor->nama_aktor = $request->nama_aktor;
            $aktor->gender = $request->gender;
            $aktor->umur= $request->umur;
            $aktor->foto = $request->foto;
            $aktor->save();

            return response()->json([
                'status' => true,
                'message' => 'data aktor berhasil dibuat',
                'data' => $aktor
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getmessage(),
            ], 500);
        }
    }
    
   public function update(Request $request, $id){
    try {
        $aktor = Aktor::find($id);

        if (!$aktor) {
            return response()->json([
                'status'  => false,
                'message' => 'data aktor tidak ada',
            ], 404);
        }

        // Validasi yang sudah diperbaiki (tidak pakai . $id)
        $request->validate([
            'nama_aktor' => 'required|max:255', 
            'gender'     => 'required|in:laki-laki,perempuan',
            'umur'       => 'required|integer',
            'foto'       => 'required'
        ]);

        $aktor->nama_aktor = $request->nama_aktor;
        $aktor->gender     = $request->gender;
        $aktor->umur       = $request->umur;
        $aktor->foto       = $request->foto;
        $aktor->save();

        return response()->json([
            'status'  => true,
            'message' => 'data aktor berhasil diedit',
            'data'    => $aktor
        ], 200);

    } catch (Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => $e->getMessage(), // Perbaikan getMessage()
        ], 500);
    }
}

      public function destroy($id){
        try {
            $aktor = Aktor::find($id);

            if (! $aktor) {
                return response()->json([
                    'status' =>false,
                    'message' => 'data aktor tidak ditemukan',
                ], 404);
            }
            $aktor->delete();
            return response()->json([
                'status'=>true,
                'message'=>'data aktor berhasil dihapus',
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],500);
              }
        }

}
