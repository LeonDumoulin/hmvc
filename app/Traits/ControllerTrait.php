<?php

namespace App\Traits;

trait ControllerTrait
{
    public $model;
    public $viewPath;
    public $route;

    /**
     * @param $view
     * @param array $params
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($view, $params = [])
    {
        return view($this->viewPath . $view, $params);
    }

    public function returnError($data)
    {
        return response()->json([

            'status' => 0,
            'error' => true,
            'errors' => $data->errors(),
            'code' => 400
        ], 400);
    }

    public function returnFail($data)
    {
        return response()->json([

            'status' => 0,
            'error' => true,
            'errors' => $data,
            'code' => 400
        ], 400);
    }

    public function returnSuccess()
    {
        return response()->json([
            'status' => 1,
            'success' => true,
            'url' => url($this->route)
        ]);
    }
}