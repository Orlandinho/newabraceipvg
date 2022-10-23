<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();

        return inertia('Patient/Index', compact('patients'));
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
            return redirect()->back()->withErrors(['create' => 'Não foi possível finalizar o cadastro']);
        }
    }

    public function show(Patient $patient)
    {
        $patient->load('address');
        return inertia('Patient/Show', compact('patient'));
    }
}
