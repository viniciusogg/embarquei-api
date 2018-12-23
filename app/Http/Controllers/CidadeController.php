<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CidadeService;

class CidadeController extends Controller
{
    private $cidadeService;
    
    public function __construct(CidadeService $cidadeService) 
    {
        $this->cidadeService = $cidadeService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cidades = $this->cidadeService->findAll();

        if (empty($cidades))
        {
            return response()->json('', 204);
        }
        return response()->json($cidades, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cidade = $request->all();

        $this->cidadeService->create($cidade);

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
        $cidade = $this->cidadeService->findById($id);

        if ($cidade)
        {
            return response()->json($cidade->toArray(), 200);
        }
        return response()->json(['response' => 'Cidade não encontrada'], 400);
    }

    public function showByNome($nome)
    {
        $cidade = $this->cidadeService->findByNome($nome);

        if ($cidade)
        {
            return response()->json($cidade->toArray(), 200);
        }
        return response()->json(['response' => 'Cidade não encontrada'], 400);
    }
    
    public function buscarCidadesComRotas()
    {
        $cidades = $this->cidadeService->buscarCidadesComRotas();
        
        if (empty($cidades))
        {
            return response()->json('', 204);
        }
        return response()->json($cidades, 200);
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
        $cidade = $request->all();

        $cidadeAtualizada = $this->cidadeService->update($cidade, $id);

        return response()->json([$cidadeAtualizada->toArray()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->cidadeService->delete($id);

        return response()->json('', 204);
    }
}
