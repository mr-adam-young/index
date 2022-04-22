<?php

namespace App\Http\Controllers;

use App\Models\CostCenter;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class CostCenterController extends Controller
{
    protected $user;
 
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->user
            ->cost_centers()
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate data
        $data = $request->only('long_name');
        $validator = Validator::make($data, [
            'long_name' => 'required|string',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new CostCenter
        $cost_center = $this->user->cost_centers()->create([
            'long_name' => $request->long_name,
            'short_name' => $request->short_name,
            'description' => $request->description,
        ]);

        //CostCenter created, return success response
        return response()->json([
            'success' => true,
            'message' => 'CostCenter created successfully',
            'data' => $cost_center
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CostCenter  $CostCenter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cost_center = $this->user->cost_centers()->find($id);
    
        if (!$CostCenter) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, CostCenter not found.'
            ], 400);
        }
    
        return $cost_center;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CostCenter  $CostCenter
     * @return \Illuminate\Http\Response
     */
    public function edit(CostCenter $cost_center)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CostCenter  $CostCenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CostCenter $cost_center)
    {
        //Validate data
        $data = $request->only('name', 'sku', 'price', 'quantity');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'sku' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, update CostCenter
        $cost_center = $cost_center->update([
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);

        //CostCenter updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'CostCenter updated successfully',
            'data' => $cost_center
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CostCenter  $CostCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(CostCenter $cost_center)
    {
        $cost_center->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'CostCenter deleted successfully'
        ], Response::HTTP_OK);
    }
}