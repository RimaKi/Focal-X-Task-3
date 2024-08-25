<?php

namespace App\Services;

use App\Models\Movie;

class movieService
{
    /**
     * @param array $data
     * @return Movie
     *
     */
    public function createMovie(array $data)
    {
        return Movie::create($data);
    }

    /**
     * @param array $data
     * @param Movie $movie
     * @return void
     *
     */
    public function updateMovie(array $data, Movie $movie)
    {
        $movie->update($data);
    }

    /**
     * @param Movie $movie
     * @return bool|null
     *
     */
    public function deleteMovie(Movie $movie)
    {
        return $movie->delete();
    }
}
