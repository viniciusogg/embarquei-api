<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VeiculoTransporteService;

class VeiculoTransporteController extends Controller
{
    private $veiculoTransporteService;
    
    public function __construct(VeiculoTransporteService $veiculoTransporteService) 
    {
        $this->veiculoTransporteService = $veiculoTransporteService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $veiculosTransporte = $this->veiculoTransporteService->findAll();

        if (empty($veiculosTransporte))
        {
            return response()->json('', 204);
        }
        return response()->json($veiculosTransporte, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $veiculoTransporte = $request->all();

        $this->veiculoTransporteService-> create($veiculoTransporte);

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
        $veiculoTransporte = $this->veiculoTransporteService->findById($id);

        if ($veiculoTransporte)
        {
            return response()->json($veiculoTransporte->toArray(), 200);
        }
        return response()->json(['response' => 'Veiculo de transporte não encontrado'], 400);
    }

    public function filtrarPorCidade($cidadeId)
    {
        $veiculos = $this->veiculoTransporteService->findByCidade($cidadeId);

        if (empty($veiculos))
        {
            return response()->json('', 204);
        }
        return response()->json($veiculos, 200);
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
        $veiculoTransporte = $request->all();

        $veiculoTransporteAtualizado = $this->veiculoTransporteService->update($veiculoTransporte, $id);

        return response()->json([$veiculoTransporteAtualizado->toArray()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->veiculoTransporteService->delete($id);

        return response()->json('', 204);
    }
}
