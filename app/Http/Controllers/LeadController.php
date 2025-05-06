<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class LeadController extends Controller
{

    public function index(Request $request)
    {
        $leads = $request->user()->leads();
        return response()->json(['leads' => $leads], 200);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        $lead = Lead::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'user_id' => $request->user()->id
        ]);
        return response()->json(['lead created' => $lead], 201);
    }

    public function show(Request $request,$id)
    {
        $lead = $request->user()->leads()->findOrFail($id);
        return response()->json(['lead' => $lead], 200);
    }

    public function update(Request $request, $id)
    {
        $lead = $request->user()->leads()->findOrFail($id);
        $validated = $request->validate([
            'name' => 'string',
            'phone' => 'string',
            'email' => 'email',
            'address' => 'string',
            'status' => 'string',
            'user_id' => 'exists:users,id'
        ]);

        $lead->update($request->only($validated));

        return response()->json(['lead edited' => $lead], 200);
    }


    public function destroy(Request $request,$id)
    {
        $lead = $request->user()->leads()->findOrFail($id);
        $lead->delete();
    }


}
