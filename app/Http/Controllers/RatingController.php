<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\updateRatingRequest;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource with average ratings
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse response()->json
     */
    public function index(Request $request)
    {
        $request->validate([
            'movie_id' => ['required', 'exists:movies,id']
        ]);
        $data = Rating::where('movie_id', $request->movie_id)->get();
        return response()->json([
            "success" => true,
            "data" => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRatingRequest $request
     * @return \Illuminate\Http\JsonResponse response()->json
     */
    public function store(StoreRatingRequest $request)
    {
        try {
            $data = $request->only(['movie_id', 'rating', 'review']);
            $data['user_id'] = auth()->user()->id;
            Rating::create($data);
            return response()->json([
                "success" => true,
                "message" => 'added successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }


    }

    /**
     * Display the specified resource.
     * @param Rating $rating
     * @return \Illuminate\Http\JsonResponse response()->json
     */
    public function show(Rating $rating)
    {
        return response()->json([
            "success" => true,
            "data" => $rating
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param updateRatingRequest $request
     * @param Rating $rating
     * @return \Illuminate\Http\JsonResponse response()->json
     */
    public function update(updateRatingRequest $request, Rating $rating)
    {
        try {
            $data = $request->only('rating', 'review');
            if (auth()->user()->id != $rating->user_id) {
                throw new \Exception('Forbidden', 403);
            }
            $rating->update($data);
            return response()->json([
                "success" => true,
                "data" => $rating
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param Rating $rating
     * @return \Illuminate\Http\JsonResponse response()->json
     */
    public function destroy(Rating $rating)
    {
        try {
            $rating->delete();
            return response()->json([
                "success" => true,
                "message" => 'deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
