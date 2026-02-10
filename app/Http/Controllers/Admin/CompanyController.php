<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::paginate(15);
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:companies',
            'website' => 'nullable|url',
            'description' => 'nullable|string',
        ]);
        
        Company::create($validated);
        
        return redirect()->route('admin.companies.index')->with('success', 'Perusahaan berhasil ditambahkan');
    }

    public function show(Company $company)
    {
        $internships = $company->internships()->with(['student', 'advisor'])->get();
        return view('admin.companies.show', compact('company', 'internships'));
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:companies,email,' . $company->id,
            'website' => 'nullable|url',
            'description' => 'nullable|string',
        ]);
        
        $company->update($validated);
        
        return redirect()->route('admin.companies.show', $company)->with('success', 'Perusahaan berhasil diperbarui');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('admin.companies.index')->with('success', 'Perusahaan berhasil dihapus');
    }
}
