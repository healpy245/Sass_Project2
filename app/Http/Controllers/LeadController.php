<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $result = Lead::all();
        return response()->json(['Leads'=>$result],200);
    }
    public function store(Request $request)
    {

        $lead = Lead::create($request->all());
        return response()->json(['Lead Created'=>$lead],201);

    }
    public function show($id)
    {
        $lead = Lead::findOrFail($id);
        return response()->json(['Lead'=>$lead],200);

    }

    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->update($request->all());
        return response()->json(['Lead Updated'=>$lead],200);

    }
    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
    }
}
