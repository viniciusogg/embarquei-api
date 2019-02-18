<?php
/**
 * Created by PhpStorm.
 * User: vinicius
 * Date: 17/02/19
 * Time: 21:09
 */

namespace App\Services;
use App\Entities\Feedback;
use App\Repositories\Abstraction\FeedbackRepositoryInterface;
use App\Services\Service;
use Carbon\Carbon;

class FeedbackService extends Service
{
    private $feedbackRepository;

    public function __construct(FeedbackRepositoryInterface $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    protected function getRepository()
    {
        return $this->feedbackRepository;
    }

    protected function criarInstancia($dados)
    {
//        $dataFormatada = date_create_from_format('Y-m-d H:i:s', $dados['data']);
//        $dataEnvio = Carbon::createFromFormat('Y-m-d H:i:s', $dataFormatada->format('Y-m-d H:i:s'));

        $feedback = new Feedback();
        $feedback->setComentario($dados['comentario']);
        $feedback->setData(Carbon::now());
        $feedback->setDetalhesPlataforma($dados['detalhesPlataforma']);
        $feedback->setIdMunicipioUsuario($dados['idMunicipioUsuario']);
        $feedback->setIdUsuario($dados['idUsuario']);
        $feedback->setTipo($dados['tipo']);

        return $feedback;
    }
}