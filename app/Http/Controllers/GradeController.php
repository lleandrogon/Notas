<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::all();

        return response()->json([
            'message' => 'Notas listadas com sucesso!',
            'grades' => $grades
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'discipline_id' => 'required|exists:disciplines,id',
            'bimonthly' => 'required|integer',
            'monthly_note' => 'required|numeric|between:0,10',
            'bimonthly_note' => 'required|numeric|between:0,10',
        ];

        $request->validate($rules);

        $monthly_note = $request->monthly_note;
        $bimonthly_note = $request->bimonthly_note;
        $average = ($bimonthly_note + $monthly_note) / 2;

        if ($average >= 6 && $average <= 10) {
            $result = 'approved';
        } else if ($average < 6 && $average >= 0) {
            $result = 'disapproved';
        } else {
            return response()->json([
                'message' => 'Notas inválidas. A média deve estar entre 0 a 10'
            ]);
        }

        $grade = Grade::create([
            'user_id' => $request->user_id,
            'discipline_id' => $request->discipline_id,
            'bimonthly' => $request->bimonthly,
            'monthly_note' => $monthly_note,
            'bimonthly_note' => $bimonthly_note,
            'average' => $average,
            'result' => $result
        ]);

        return response()->json([
            'message' => 'Nota cadastrada com sucesso!',
            'grade' => $grade
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $grade = Grade::find($id);

        if (!$grade) {
            return response()->json([
                'message' => 'Nota não encontrada!',
            ], 404);
        } 

        return response()->json([
            'message' => 'Nota encontrada com sucesso!',
            'grade' => $grade
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $grade = Grade::find($id);

        if (!$grade) {
            return response()->json([
                'message' => 'Nota não encontrada!',
            ], 404);
        }

        $rules = [
            'user_id' => 'required|exists:users,id',
            'discipline_id' => 'required|exists:disciplines,id',
            'bimonthly' => 'required|integer',
            'monthly_note' => 'required|numeric|between:0,10',
            'bimonthly_note' => 'required|numeric|between:0,10',
        ];

        $request->validate($rules);

        $monthly_note = $request->monthly_note;
        $bimonthly_note = $request->bimonthly_note;
        $average = ($bimonthly_note + $monthly_note) / 2;

        if ($average >= 6 && $average <= 10) {
            $result = 'approved';
        } else if ($average < 6 && $average >= 0) {
            $result = 'disapproved';
        } else {
            return response()->json([
                'message' => 'Notas inválidas. A média deve estar entre 0 a 10'
            ]);
        }

        $grade->update([
            'user_id' => $request->user_id,
            'discipline_id' => $request->discipline_id,
            'bimonthly' => $request->bimonthly,
            'monthly_note' => $monthly_note,
            'bimonthly_note' => $bimonthly_note,
            'average' => $average,
            'result' => $result
        ]);

        return response()->json([
            'message' => 'Nota editada com sucesso!',
            'grade' => $grade
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grade = Grade::find($id);

        if (!$grade) {
            return response()->json([
                'message' => 'Nota não encontrada!',
            ], 404);
        }

        $grade->delete();

        return response()->json([
            'message' => 'Nota deletada com sucesso',
            'grade' => $grade
        ], 200);
    }
}
