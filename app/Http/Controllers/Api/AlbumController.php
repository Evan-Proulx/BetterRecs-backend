<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $albums = Auth::user()->albums()->get(); // Fetch the albums

        // Optionally, you can transform the data if needed
        $albums = $albums->map(function($album) {
            return [
                'id' => $album->id,
                'spotify_id' => $album->spotify_id,
                'title' => $album->title,
                'artist' => $album->artist,
                'release_date' => $album->release_date,
                'genre' => $album->genre,
                'image_url' => $album->image_url,
            ];
        });

        return response()->json([
            'message' => 'Albums fetched successfully',
            'data' => $albums
        ], 200);    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $album = Album::firstOrCreate(
            ['spotify_id' => $request->spotify_id],
            $request->all()
        );

        Auth::user()->albums()->syncWithoutDetaching($album->id);

        return response()->json([
            'message' => 'Album created successfully',
            'data' => $album
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        // Get the authenticated user
        $user = Auth::user();

        // Ensure the album exists and is related to the user
        $album = $user->albums()->find($id);

        if ($album) {
            // Transform the album data if needed
            $albumData = [
                'id' => $album->id,
                'spotify_id' => $album->spotify_id,
                'title' => $album->title,
                'artist' => $album->artist,
                'release_date' => $album->release_date,
                'genre' => $album->genre,
                'image_url' => $album->image_url,
            ];

            return response()->json([
                'message' => 'Album fetched successfully',
                'data' => $albumData
            ], 200);
        }

        return response()->json([
            'message' => 'Album not found or not associated with user'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        // Get the authenticated user
        $user = Auth::user();

        // Ensure the album exists and is related to the user
        $album = $user->albums()->where('spotify_id', $id)->first();

        if ($album) {
            // Detach the album from the user's albums relationship
            $user->albums()->detach($album->id);

            return response()->json([
                'message' => 'Album removed from user inventory successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'Album not found or not associated with user'
        ], 404);
    }
}
