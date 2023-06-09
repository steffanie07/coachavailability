<?php
namespace App\Http\Controllers\API;

use App\Models\Coach; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class CoachController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coaches = Coach::with('availabilities')->get();
        return response()->json($coaches);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $coach = Coach::create($request->all());
    
        return response()->json(['coach_id' => $coach->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}


