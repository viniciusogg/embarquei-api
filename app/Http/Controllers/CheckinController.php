<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CheckinService;

class CheckinController extends Controller
{
    private $checkinService;

    public function __construct(CheckinService $checkinService)
    {
        $this->checkinService = $checkinService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkins = $this->checkinService->findAll();

        if (empty($checkins))
        {
            return response()->json('', 204);
        }
        return response()->json($checkins, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dadosCheckin = $request->all();

        $checkinSalvo = $this->checkinService->create($dadosCheckin);

        return response()->json($checkinSalvo->toArray(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $checkin = $this->checkinService->findById($id);

        if ($checkin)
        {
            return response()->json($checkin->toArray(), 200);
        }
        return response()->json(['response' => 'Checkin não encontrado'], 400);
    }

    public function buscarPorEstudante($id)
    {
        $checkin = $this->checkinService->getCheckinByIdEstudante($id);

        if ($checkin)
        {
            return response()->json($checkin->toArray(), 200);
        }
        return response()->json(['response' => 'Checkin não encontrado'], 400);
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
        $checkin = $request->all();

        $checkinAtualizado = $this->checkinService->update($checkin, $id);

        return response()->json($checkinAtualizado->toArray(), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->checkinService->delete($id);

        return response()->json('', 204);
    }
}
