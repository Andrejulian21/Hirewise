<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpsertCompanyRequest;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyAccountController extends Controller
{
    public function show()
    {
        $company = Company::where('user_id', Auth::id())->first();

        return view('empresa.company.manage', compact('company'));
    }

    public function store(UpsertCompanyRequest $request)
    {
        $user = Auth::user();

        if ($user->company) {
            return redirect()->route('empresa.company.show')
                ->with('error', 'Ya tienes una empresa vinculada.');
        }

        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('company-logos', 'public');
        }

        $data['user_id'] = $user->id;

        Company::create($data);

        return redirect()->route('empresa.company.show')->with('status', 'Empresa creada correctamente.');
    }

    public function update(UpsertCompanyRequest $request)
    {
        $company = Company::where('user_id', Auth::id())->firstOrFail();

        $data = $request->validated();

        if ($request->hasFile('logo')) {
            // borra logo anterior (opcional)
            if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }
            $data['logo'] = $request->file('logo')->store('company-logos', 'public');
        }

        $company->update($data);

        return redirect()->route('empresa.company.show')->with('status', 'Datos de la empresa actualizados.');
    }

    public function destroy()
    {
        // Opción: desvincular (si tu dominio lo permite)
        $company = Company::where('user_id', Auth::id())->firstOrFail();

        // Si usas jobs, valida que no tenga vacantes activas antes de eliminar o desvincular
        // $company->jobs()->exists() ? abort(400, 'Tiene vacantes…') : null;

        $company->delete(); // si usas SoftDeletes, queda en papelera. Cambia a ->forceDelete() para eliminar.
        // Alternativa: $company->update(['user_id' => null]); si permites que quede “sin dueño” (tu esquema actual no).

        return redirect()->route('empresa.company.show')->with('status','Empresa eliminada.');
    }
}
