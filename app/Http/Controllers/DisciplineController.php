<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::id();
        
        $disciplines = Discipline::with(['grades' => function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        }])->get();

        return response()->json([
            'message' => 'Disciplinas listadas com sucesso!',
            'disciplines' => $disciplines
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required'
        ];

        $request->validate($rules);

        $discipline = Discipline::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Disciplina cadastrada com sucesso!',
            'discipline' => $discipline
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $discipline = Discipline::find($id);

        if (!$discipline) {
            return response()->json([
                'message' => 'Disciplina não encontrada!',
            ], 404);
        }
        
        return response()->json([
            'message' => 'Disciplina encontrada com sucesso!',
            'discipline' => $discipline
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $discipline = Discipline::find($id);

        if (!$discipline) {
            return response()->json([
                'message' => 'Disciplina não encontrada!',
            ], 404);
        }

        $rules = [
            'name' => 'required'
        ];

        $request->validate($rules);

        $discipline->update([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Disciplina atualizada com sucesso!',
            'discipline' => $discipline
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $discipline = Discipline::find($id);

        if (!$discipline) {
            return response()->json([
                'message' => 'Disciplina não encontrada!',
            ], 404);
        }

        $discipline->delete();

        return response()->json([
            'message' => 'Disciplina deletada com sucesso',
            'discipline' => $discipline
        ], 200);
    }
}
