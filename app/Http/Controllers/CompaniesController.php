<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Facade;

class CompaniesController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return response()->json(['data'=>$companies, 'super admin is'=> Auth::user()],200);

    }
    public function store(Request $request)
    {
        $company = Company::create($request->all());
        return response()->json($company,201);
    }
    public function show($id)
    {
        $company = Company::findOrFail($id);
        return response()->json($company,200);
    }
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $company->update($request->all());
        return response()->json($company,200);

    }
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json(['message'=>'deleted'],200);
    }
}
