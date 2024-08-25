<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexMoviesRequest;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use App\Services\movieService;

class MovieController extends Controller
{
    protected $movieService;

    /*
     * use Service in controller
     * in this controller use dependency injection
     */
    public function __construct(movieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * Display a listing of the resource. with filtrating and pagination and ordering
     * @param IndexMoviesRequest $request
     * @return \Illuminate\Http\JsonResponse response()->json
     */
    public function index(IndexMoviesRequest $request)
    {
        try {
            $data = Movie::query()
                ->when($request->genre, function ($query) use ($request) {
                    return $query->where('genre', 'like', '%' . $request->genre . '%');
                })->when($request->director, function ($query) use ($request) {
                    return $query->where('director', 'like', '%' . $request->director . '%');
                })->orderBy('release_year', $request->isAsc ? 'asc' : 'desc')
                ->paginate($request->movies_number ?? 20);

            return response()->json([
                "success" => true,
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage using movieService
     * @param StoreMovieRequest $request
     * @return \Illuminate\Http\JsonResponse response()->json
     */
    public function store(StoreMovieRequest $request)
    {
        try {
            $data = $request->only(['title', 'description', 'director', 'genre', 'release_year']);
            $movie = $this->movieService->createMovie($data);
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
     * @param Movie $movie
     * @return \Illuminate\Http\JsonResponse response()->json
     */
    public function show(Movie $movie)
    {
        try {
            return response()->json([
                "success" => true,
                "data" => $movie
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage using movieService
     * @param UpdateMovieRequest $request
     * @return \Illuminate\Http\JsonResponse response()->json
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        try {
            $data = $request->only(['title', 'description', 'director', 'genre', 'release_year']);
            $this->movieService->updateMovie($data, $movie);
            return response()->json([
                "success" => true,
                "data" => $movie
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }

    }

    /**
     * Remove the specified resource from storage using movieService
     * @param Movie $movie
     * @return \Illuminate\Http\JsonResponse response()->json
     */
    public function destroy(Movie $movie)
    {
        try {
            if (!$this->movieService->deleteMovie($movie)) {
                throw new \Exception('wrong in delete');
            }
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
