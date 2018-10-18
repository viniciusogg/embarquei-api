<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CursoService;

class CursoController extends Controller
{
    private $cursoService;
    
    public function __construct(CursoService $cursoService) 
    {
        $this->cursoService = $cursoService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cursos = $this->cursoService->findAll();

        if (empty($cursos))
        {
            return response()->json('', 204);
        }

        return response()->json($cursos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $curso = $this->cursoService->findById($id);

        if ($curso)
        {
            return response()->json($curso->toArray(), 200);
        }

        return response()->json(['response' => 'Curso não encontrado'], 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
