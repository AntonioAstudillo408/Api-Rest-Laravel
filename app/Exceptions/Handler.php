<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{


    use ApiResponser;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];



    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if($e instanceof ValidationException)
        {
            return $this->convertValidationExceptionToResponse($e , $request);

        }else if($e instanceof ModelNotFoundException)
        {
            $modelo = class_basename($e->getModel());
            return $this->errorResponse("No existe una instancia de {$modelo}" , 404);
        }
        else if($e instanceof NotFoundHttpException)
        {
            return $this->errorResponse("La ruta solicitada no existe" , 404);
        }
        else if($e instanceof MethodNotAllowedHttpException )
        {
            return $this->errorResponse("El método no esta soportado para la ruta solicitada" , 405);
        }
        else if($e instanceof AuthenticationException)
        {
            return $this->errorResponse("No autenticado" , 401);
        }
        else if($e instanceof AuthorizationException)
        {
            return $this->errorResponse("No posee permisos para ejecutar esta acción" , 403);
        }
        else if($e instanceof HttpException)
        {
            return $this->errorResponse($e->getMessage() , $e->getStatusCode());
        }
        else if($e instanceof QueryException)
        {
            if($e->errorInfo[1] === 1451)
            {
                return $this->errorResponse('No podemos eliminar ese registro, porque se encuentra asociado a otro.' , 409);
            }
        }
        else
        {
            if(config('app.debug'))
            {
                return parent::render($request , $e);

            }else{
                return $this->errorResponse('Error en el servidor 101' , 500);
            }

        }

    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors , 422);
    }
}
