<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InstituicaoEnsinoService;

class InstituicaoEnsinoController extends Controller
{
    private $instituicaoEnsinoService;
    
    public function __construct(InstituicaoEnsinoService $instituicaoEnsinoService) 
    {
        $this->instituicaoEnsinoService = $instituicaoEnsinoService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instituicoesEnsino = $this->instituicaoEnsinoService->findAll();

        if (empty($instituicoesEnsino))
        {
            return response()->json('', 204);
        }
        return response()->json($instituicoesEnsino, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $instituicaoEnsino = $request->all();

        $this->instituicaoEnsinoService->create($instituicaoEnsino);

        return response()->json(['response' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $instituicaoEnsino = $this->instituicaoEnsinoService->findById($id);

        if ($instituicaoEnsino)
        {
            return response()->json($instituicaoEnsino->toArray(), 200);
        }
        return response()->json(['response' => 'Instituição de ensino não encontrada'], 400);
    }

    public function buscarInstituicoesSemMotorista($cidadeId)
    {
        $instituicoesEnsino = $this->instituicaoEnsinoService->buscarInstituicoesSemMotorista($cidadeId);

        if (empty($instituicoesEnsino))
        {
            return response()->json('', 204);
        }
        return response()->json($instituicoesEnsino, 200);
    }

    public function buscarInstituicoesSemVeiculo($cidadeId)
    {
        $instituicoesEnsino = $this->instituicaoEnsinoService->buscarInstituicoesSemVeiculo($cidadeId);

        if (empty($instituicoesEnsino))
        {
            return response()->json('', 204);
        }
        return response()->json($instituicoesEnsino, 200);
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
        $instituicaoEnsino = $request->all();

        $instituicaoEnsinoAtualizada = $this->instituicaoEnsinoService->update($instituicaoEnsino, $id);

        return response()->json([$instituicaoEnsinoAtualizada->toArray()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->instituicaoEnsinoService->delete($id);

        return response()->json('', 204);
    }
}
