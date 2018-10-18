<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PontoParadaController extends Controller
{
    private $pontoParadaService;
    
    public function __construct(PontoParadaService $pontoParadaService) 
    {
        $this->pontoParadaService = $pontoParadaService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pontosParada = $this->pontoParadaService->findAll();

        if (empty($pontosParada))
        {
            return response()->json('', 204);
        }

        return response()->json($pontosParada, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pontoParada = $request->all();
        
        $this->pontoParadaService->create($pontoParada);

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
        $pontoParada = $this->pontoParadaService->findById($id);

        if ($pontoParada)
        {
            return response()->json($pontoParada->toArray(), 200);
        }

        return response()->json(['response' => 'Ponto de parada não encontrado'], 400);
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
        $pontoParada = $request->all();

        $pontoParadaAtualizado = $this->pontoParadaService->update($pontoParada, $id);

        return response()->json([$pontoParadaAtualizado->toArray()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->pontoParadaService->delete($id);

        return response()->json('', 204);
    }
}
