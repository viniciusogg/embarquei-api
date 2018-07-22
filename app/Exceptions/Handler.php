<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\ORMInvalidArgumentException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ConversionException)
        {
            return response()->json(['devError' => $exception->getMessage(),
                    'userError' => 'Erro ao tentar converter propriedade'], 400);
        }
        else if ($exception instanceof EntityNotFoundException)
        {
            return response()->json(['devError' => $exception->getMessage(),
                    'userError' => 'Recurso não encontrado'], 400);
        }
        else if ($exception instanceof ORMInvalidArgumentException)
        {
            return response()->json(['devError' => $exception->getMessage(),
                    'userError' => 'Argumento inválido'], 400);
        }
        
        return parent::render($request, $exception);
    }
}
