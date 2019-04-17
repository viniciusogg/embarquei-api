<?php

namespace App\Exceptions;

use Exception;
use ErrorException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\NullFieldException;
use App\Exceptions\NaoEncontradoException;
use App\Exceptions\VazioException;
use App\Exceptions\ValorEnumInvalidoException;

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
        // Tratamento da exceção lançada quando o formato do id de
        // um recurso passado por parâmetro é inválido
        if ($exception instanceof ConversionException)
        {
            return response()->json([
                'devError' => $this->dataExceptionDev($exception),
                'userError' => 'Erro ao tentar converter propriedade'], 400);
        }
        
        //
        else if ($exception instanceof EntityNotFoundException)
        {
            return response()->json([
                'devError' => $this->dataExceptionDev($exception),
                'userError' => 'Recurso não encontrado'], 400);
        }
        
        //
        else if ($exception instanceof ORMInvalidArgumentException)
        {
            return response()->json([
                'devError' => $this->dataExceptionDev($exception),
                'userError' => 'Argumento inválido'], 400);
        }
        
        // Tratamento da excessão lançada quando as credências do 
        // usuário são inválidas
        else if ($exception instanceof InvalidCredentialsException)
        {
            return response()->json(['devError' => $this->dataExceptionDev($exception), 
                    'userError' => 'O número ou a senha informada está incorreta.'], 401);
        }
        
        // Tratamento da excessão lançada quando o cookie do 
        // refresh token é removido ou está expirado
        else if ($exception instanceof ErrorException && 
                ($exception->getMessage() === 'Undefined index: refresh_token'))
        {            
            return response()->json([
                'devError' => $this->dataExceptionDev($exception),
                'userError' => 'Faça login para acessar o sistema.'], 400);
        }
        
        // Tratamento da excessão lançada quando um campo é nulo      
        else if ($exception instanceof NullFieldException || $exception instanceof NotNullConstraintViolationException)
        {
            return response()->json(['devError' => $this->dataExceptionDev($exception), 
                'userError' => 'O campo não pode ser nulo.'], 401);
        }
        
        // Tratamento da excessão lançada quando nenhum registro é encontrado para uma busca
        // feita através de um dado específico (id, nome etc)
        else if ($exception instanceof NaoEncontradoException) 
        {
            return response()->json(['devError' => $this->dataExceptionDev($exception),
                    'userError' => $exception->getMessage()], 400);
        }

        // Tratamento da excessão lançada quando nenhum registro é encontrado em uma tabela
        else if ($exception instanceof VazioException) 
        {
            return response()->json(['devError' => $this->dataExceptionDev($exception),
                    'userError' => $exception->getMessage()], 400);
        }

        // Tratamento da excessão lançada quando um valor inválido é passado para uma propriedade ENUM
        else if ($exception instanceof ValorEnumInvalidoException)
        {
            return response()->json(['devError' => $this->dataExceptionDev($exception),
                    'userError' => $exception->getMessage()], 400);
        }
        return parent::render($request, $exception);
    }
    
    private function dataExceptionDev($exception)
    {
        $data = [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace()
        ];
        return $data;
    }
}
