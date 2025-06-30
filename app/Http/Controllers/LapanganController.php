<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.lapangan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $field = Field::with(['category', 'facilities', 'schedules' => function($q) {
            $q->where('is_active', true)->orderBy('day_of_week')->orderBy('start_time');
        }])->where('slug', $slug)->firstOrFail();

        return view('pages.lapangan.show', [
            'fields' => [$field], // agar tetap kompatibel dengan blade @forelse
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Field $field)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Field $field)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Field $field)
    {
        //
    }
}
