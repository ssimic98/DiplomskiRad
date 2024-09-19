<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;
use Illuminate\Support\Facades\Auth;

class FavoriteDogController extends Controller
{
    public function AddFavorite(Request $request)
    {
        $request->validate([
            'dog_id' => 'required|exists:dogs,id',
        ]);

        $user = Auth::user();

        if ($user->role !== 'user') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $dog = Dog::findOrFail($request->dog_id);
        if (!$user->favoriteDogs->contains($dog->id)) {
            $user->favoriteDogs()->attach($dog->id);
        }

        return response()->json(['success' => true]);
    }

    public function RemoveFavorite(Request $request)
    {
        $request->validate([
            'dog_id' => 'required|exists:dogs,id',
        ]);

        $user = Auth::user();
        if ($user->role !== 'user') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $dog = Dog::findOrFail($request->dog_id);
        if ($user->favoriteDogs->contains($dog->id)) {
            $user->favoriteDogs()->detach($dog->id);
        }

        return response()->json(['success' => true]);
    }
}
