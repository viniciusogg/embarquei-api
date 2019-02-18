<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FeedbackService;

class FeedbackController extends Controller
{
    private $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    protected function getService()
    {
        return $this->feedbackService;
    }

    protected function getMensagemErro()
    {
        return 'Feedback não encontrado';
    }
}
