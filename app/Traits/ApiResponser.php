<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponser
{
    /**
     * Devuelve una respuesta exitosa
     *
     * @param mixed $data Data a devolver
     * @param int $code Codigo de respuesta HTTP
     *
     * @return \Illuminate\Http\Response
     */
    private function successResponse($data, $code) {
        return response()->json($data, $code);
    }

    /**
     * Devuelve una respuesta fallida
     *
     * @param string $message Mensaje de error
     * @param int $code Codigo de respuesta HTTP
     *
     * @return \Illuminate\Http\Response
     */
    protected function errorResponse($message, $code) {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    /**
     * Devuelve una respuesta a una peticion de show all
     *
     * @param Collection $collection Coleccion de objetos a devolver
     * @param int $code Codigo de respuesta HTTP
     *
     * @return \Illuminate\Http\Response
     */
    protected function showAll(Collection $collection, $code = 200) {

        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }

        $transformer = $collection->first()->transformer;

        $collection = $this->transformData($collection, $transformer);

        return $this->successResponse($collection, $code);
    }

    /**
     * Devuelve una respuesta a una peticion de show one
     *
     * @param Model $instance Instancia de modelo a devolver
     * @param int $code Codigo de respuesta HTTP
     *
     * @return \Illuminate\Http\Response
     */
    protected function showOne(Model $instance, $code = 200) {
        $transformer = $instance->transformer;

        $instance = $this->transformData($instance, $transformer);

        return $this->successResponse($instance, $code);
    }

    /**
     * Devuelve una respuesta con mensaje de success
     *
     * @param string $message Mensaje a devolver
     * @param int $code Codigo de respuesta HTTP
     *
     * @return \Illuminate\Http\Response
     */
    protected function showMessage($message, $code = 200) {
        return $this->successResponse(['data' => $message], $code);
    }

    /**
     * Transforma la data de una respuesta
     *
     * @param $data
     * @param $transformer
     * @return array
     */
    protected function transformData($data, $transformer) {
        $transformation = fractal($data,  new $transformer);

        return $transformation->toArray();
    }
}