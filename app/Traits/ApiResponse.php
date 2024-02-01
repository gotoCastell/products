<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

trait ApiResponse
{
    public string $responseTitle = 'Éxito';
    public string $responseDescription = '';
    public string $errorLogClass = '';
    public string $errorLogMethod = '';
    public array $validation_rules = [];
    //variable global para obtener los parametros de validacion
    public object $validator_errors;

    public function validator(): bool
    {
        if (isset($this->validation_rules)) {
            $validator = Validator::make($this->request->all(), $this->validation_rules);
            if ($validator->fails()) {
                $this->validator_errors = $validator->errors();
                return false;
            }
            return true;
        }
        return true;
    }

    public function setTitleApiResponse($title): void
    {
        $this->responseTitle = $title;
    }

    public function setDescriptionApiResponse($description): void
    {
        $this->responseDescription = $description;
    }

    public function setClassErrorLog($class): void
    {
        $this->errorLogClass = $class;
    }
    public function setMethodErrorLog($method): void
    {
        $this->errorLogMethod = $method;
    }


    public function setErrorLog($class, $method, $file, $error, $line): void
    {
        Log::error('');
        Log::error('----------------------------------------------------------------------------');
        Log::error('¡Error!');
        Log::error('Class: ' . $class);
        Log::error('Method: ' . $method);
        Log::error('File: ' . $file);
        Log::error('Line: ' . $line);
        Log::error('Description: ' . $error);
        Log::error('----------------------------------------------------------------------------');
        Log::error('');
    }


    /**
     * Esta funcion regresa la respuesta de error en fromato json
     *
     * @param object|array $error -
     * @param int $code - codigo de respuesta
     * @return
     */
    public function handleError($error, $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {

        if (is_array($error)) {
            $this->setErrorLog(
                $this->errorLogClass,
                $this->errorLogMethod,
                isset($error['file']) ? $error['file'] : '',
                isset($error['messages']) ? $error['messages'] : '',
                isset($error['line']) ? $error['line'] : '',
            );
        }

        return response()->json([
            'title' => $this->responseTitle === 'Éxito' ? 'Advertencia' : $this->responseTitle,
            'description' => $this->responseDescription,
            'error' => $error,
            'code' => $code
        ], $code);
    }


    /**
     * Esta funcion regresa la respuesta en fromato json
     *
     * @param object|array $data -
     * @param String $code - codigo de respuesta
     * @return JsonResponse
     */
    public function response(
        null|string|int|object|array $data = [],
        string                       $code = ResponseAlias::HTTP_OK
    ): JsonResponse {
        return response()->json([
            'title' => $this->responseTitle,
            'description' => $this->responseDescription,
            'data' => $data
        ], $code);
    }
}
