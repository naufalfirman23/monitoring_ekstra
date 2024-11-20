<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string',
            'password' => 'required|string',
        ]);
        $siswa = Siswa::where('nis', $request->nis)->first();
    
        if (!$siswa) {
            return response()->json(['error' => 'NIS tidak ditemukan.'], 404);
        }
        $user = User::find($siswa->id_user);
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'NIS atau password salah.'], 401);
        }
        if ($user->role !== 'siswa') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $token = $user->createToken('UniTekMandaku')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            
        ]);
    }
    
}
