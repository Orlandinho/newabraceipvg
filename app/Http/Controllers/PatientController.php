<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::query()
            ->when(request()->input('search'), function($query, $search) {
                $query->where('name','like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(8, ['id','name','dob'])
            ->withQueryString();

        $filters = request()->only(['search']);

//        $patients = DB::table('patients')
//            ->when(request()->input('search'), function($query, $search) {
//                $query->where('name','like', "%{$search}%");
//            })
//            ->orderBy('name')
//            ->paginate(8, ['id', 'name', DB::raw("DATE_FORMAT(dob,'%d/%m/%Y') as birthday"), DB::raw('floor(DATEDIFF(CURRENT_DATE(), dob) / 365.25) as age')])
//            ->withQueryString();

        return inertia('Patient/Index', compact('patients','filters'));
    }

    public function create()
    {
        return inertia('Patient/Create');
    }

    public function store(PatientRequest $request)
    {
        $attributes = $request->validated();
        try {
            DB::transaction(function () use ($attributes) {
                $newPatient = Patient::create([
                    'name' => $attributes['name'],
                    'dob' => $attributes['dob'],
                    'email' => $attributes['email']
                ]);

                $newPatient->address()->create([
                    'zipcode' => $attributes['zipcode'],
                    'street' => $attributes['street'],
                    'region' => $attributes['region'],
                    'city' => $attributes['city'],
                ]);
            });

            return redirect()->route('patient.create')->with('success', 'Dados cadastrados com sucesso');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['create' => 'N??o foi poss??vel finalizar o cadastro']);
        }
    }

    public function show(Patient $patient)
    {
        $patient->load('address');
        return inertia('Patient/Show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $patient->load('address');
        return inertia('Patient/Edit', compact('patient'));
    }

    public function update(PatientRequest $request, Patient $patient)
    {
        $attributes = $request->validated();
        try {
            DB::transaction(function () use ($attributes, $patient) {
                $patient->update([
                    'name' => $attributes['name'],
                    'dob' => $attributes['dob'],
                    'email' => $attributes['email']
                ]);

                $patient->address()->update([
                    'zipcode' => $attributes['zipcode'],
                    'street' => $attributes['street'],
                    'region' => $attributes['region'],
                    'city' => $attributes['city'],
                ]);
            });

            return redirect()->route('patient.create')->with('success', 'Dados cadastrados com sucesso');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['create' => 'N??o foi poss??vel finalizar o cadastro']);
        }
    }

    public function destroy(Patient $patient)
    {
        try {
            $patient->delete();
            return redirect()->route('patient.index')->with('success', 'Registro apagado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['create' => 'N??o foi poss??vel deletar o registro']);
        }
    }
}
