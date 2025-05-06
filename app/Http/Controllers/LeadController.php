<?php

namespace App\Http\Controllers;

use App\DTOs\LeadDTO;
use App\Enums\LeadStatus;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule as ValidationRule;

class LeadController extends Controller
{

    public function getLeadData(Lead $lead) {}










    public function index(Request $request)
    {
        $leads = $request->user()->leads();
        return response()->json(data: LeadDTO::collection($leads));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique',
            'address' => 'nullable|string',

        ]);

        $lead = Lead::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'user_id' => $request->user()->id,
            'company_id' => $request->user()->company_id
        ]);
        return response()->json(data: LeadDTO::fromModel($lead));
    }

    public function show(Request $request, $id)
    {
        $lead = $request->user()->leads()->find($id)->first();
        return response()->json(data: LeadDTO::fromModel($lead));
    }

    public function update(Request $request, $id)
    {
        $lead = $request->user()->leads()->findOrFail($id)->first();
        $validated = $request->validate([
            'name' => 'string',
            'phone' => 'string',
            'email' => 'email',
            'address' => 'string',
            'status' => [
                'string',
                ValidationRule::in(array_column(LeadStatus::cases(), 'value'))
            ],
            'user_id' => 'exists:users,id'

        ]);

        $lead->update($request->only($validated));


        return response()->json(data: LeadDTO::fromModel($lead));
    }


    public function destroy(Request $request, $id)
    {
        $lead = $request->user()->leads()->findOrFail($id);
        $lead->delete();
    }
}
