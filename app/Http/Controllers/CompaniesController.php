<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Facade;

class CompaniesController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $users = $user->company()->users();
        $leads = $user->company()->leads();
        return response()->json([
            "company" => $user->company(),
            "users" => $users,
            "leads" => $leads
        ], 200);
    }



    public function update(Request $request)
    {
        $company = $request->user()->company();
        $request->validate([
            'name' => 'required|string'
        ]);
        $company->update($request->all());
        return response()->json($company, 200);
    }





    public function destroy(Request $request)
    {
        $company = $request->user()->company();
        $company->delete();
        return response()->json(['message' => 'deleted'], 200);
    }
}
