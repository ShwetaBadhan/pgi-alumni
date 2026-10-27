<?php

namespace App\Http\Controllers;

use App\Models\RegistrationType;
use Illuminate\Http\Request;

class RegistrationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrationTypes = RegistrationType::latest()->get();
        return view('backend.pages.registration-types.index', compact('registrationTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        RegistrationType::create([
            'name'   => $request->name,
            'amount' => $request->amount,
            'status' => $request->status,
        ]);

        return redirect()->route('registration-types.index')->with('success', 'Registration Type created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegistrationType $registrationType)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $registrationType->update([
            'name'   => $request->name,
            'amount' => $request->amount,
            'status' => $request->status,
        ]);

        return redirect()->route('registration-types.index')->with('success', 'Registration Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegistrationType $registrationType)
    {
        // Uses softDeletes if configured in your model, otherwise hard deletes
        $registrationType->delete();

        return redirect()->route('registration-types.index')->with('success', 'Registration Type deleted successfully.');
    }
}