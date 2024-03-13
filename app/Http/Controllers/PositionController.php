<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Services\PositionService;
use App\Http\Requests\PositionRequest;

class PositionController extends Controller
{

    protected $positionService;

    // Constructor

    public function __construct(PositionService $position)
    {
        $this->positionService = $position;
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PositionRequest $request)
    {
        dd($request->all());
        try {
            $isInserted = $this->positionService->storeData();
            if (!$isInserted) {
                return response()->json(['message' => 'Cound not save position.'], 400);
            }
            return response()->json(['message' => 'Successfully position saved.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        try{
           $position = Position::orderBy('id','DESC')->get();
            return response()->json(
                $position,
                200
            );
        }catch(Exception $e){}
            return response()->json([
                'message' => 'Internale serve error',
                ''
            ],5000);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $position = Position::findOrFail($id);
            if (!$position->delete()) {
                return response()->json(['message' => 'Could not delete position.'], 400);
            } else {
                return response()->json(['message' => 'Successfully position deleted.'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error.'], 500);
        }
    }
}
