<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MotoristaService;

class MotoristaController extends Controller
{
    private $motoristaService;
    
    public function __construct(MotoristaService $motoristaService) 
    {
        $this->motoristaService = $motoristaService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motoristas = $this->motoristaService->findAll();

        if (empty($motoristas))
        {
            return response()->json('', 204);
        }

        return response()->json($motoristas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $motorista = $request->all();
        
        $this->motoristaService->create($motorista);

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
        $motorista = $this->motoristaService->findById($id);

        if ($motorista)
        {
            return response()->json($motorista->toArray(), 200);
        }

        return response()->json(['response' => 'Motorista não encontrado'], 400);
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
        $motorista = $request->all();

        $motoristaAtualizado = $this->motoristaService->update($motorista, $id);

        return response()->json([$motoristaAtualizado->toArray()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->motoristaService->delete($id);

        return response()->json('', 204);
    }
}
