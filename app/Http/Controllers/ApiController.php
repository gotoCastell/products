<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiResponse;

    /**
     * @var Request
     */
    public $request;


    /**
     * Aqui se asignaran los atributos que se inyectaran dinamicamente desde el
     * request, esto es unicamente para controlar cuales atributos se inyectaron
     * y cuales no.
     *
     * @var dynamicInjection
     */
    public $dynamicInjection = [];


    /**
     * RequestService constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->inject();
    }

    /**
     * Esta funcion injecta dinamicamente los parametros de request
     * para acceder a ellos desde la clase
     *
     * @return void
     */
    private function inject(): void
    {
        foreach ($this->request->all() as $name => $param) {
            $this->{$name} = $param;
        }

        if ($this->request->route())
            foreach ($this->request->route()->parameters as $name => $param) {
                $this->{$name} = $param;
            }
    }

    /**
     * Este metodo magico se usara para determinar si el atributo que se pretende acceder
     * existe si es que fue generado dinamicamente desde la inyeccion
     *
     * @param $name
     * @return |null
     */
    public function __get($name)
    {
        return $this->dynamicInjection[$name] ?? null;
    }


    /**
     * Este metodo magico lo usamos para controlar las inyecciones registrando
     * los atributos que se crean
     *
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value): void
    {
        $this->dynamicInjection[$name] = $value;
    }
}
