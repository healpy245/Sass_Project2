<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class LeadController extends Controller
{

    public function index()
    {
        $leads = Lead::where('company_id', Auth::user()->company_id)->get();
        return response()->json(['leads' => $leads], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id'
        ]);

        $lead = Lead::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'company_id' => Auth::user()->company_id,
            'user_id' => $request->user_id,
        ]);
        return response()->json(['lead' => $lead], 200);
    }

    public function show($id)
    {
        $lead = Lead::where('company_id', Auth::user()->company_id)->findOrFail($id);
        return response()->json(['lead' => $lead], 200);
    }

    public function update(Request $request, $id)
    {
        $lead = Lead::where('company_id', Auth::user()->company_id)->findOrFail($id);
        $request->validate([
            'name' => 'string',
            'phone' => 'string',
            'email' => 'email',
            'address' => 'string',
            'status' => 'string',
            'user_id' => 'exists:users,id'
        ]);

        $lead->update($request->only([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'status' => $request->status,
            'user_id' => $request->user_id

        ]));

        return response()->json(['lead edited'=> $lead], 200);
    }
}
