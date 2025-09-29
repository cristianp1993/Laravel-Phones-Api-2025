<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;
use App\Http\Requests\StorePhoneRequest;
use App\Http\Requests\UpdatePhoneRequest;

class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Phone::query()->latest()->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhoneRequest $request)
    {
        $phone = Phone::create($request->validated());
        return response()->json($phone, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Phone $phone)
    {
        return $phone;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Phone $phone)
    {
        $phone->update($request->validated());
        return $phone;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Phone $phone)
    {
        $phone->delete();
        return response()->noContent();
    }
}
