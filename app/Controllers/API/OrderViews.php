<?php

namespace App\Controllers\API;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class OrderViews extends ResourceController
{
    protected $modelName = 'App\Models\ViewModel';
    protected $format    = 'json';
    
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index($order_id = NULL)
    {
        try {
            if($order_id == NULL){
                return $this->failValidationErrors('No se ha pasado un ID valido');
            }
            $views = $this->model->where('order_id',$order_id)->get()->getResult('array');
            return $this->respond($views);
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($order_id = NULL, $user_id = NULL)
    {
        try {
            if($order_id == NULL || $user_id == NULL){
                return $this->failValidationErrors('No se ha pasado un ID valido');
            }
            $view = $this->model->where(['order_id' => $order_id, 'user_id' => $user_id])->first();
            if($view == NULL){
                return $this->failNotFound('No se ha encontrado');
            }
            return $this->respond($view);
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //try {
            $view = $this->request->getJSON();
            if($this->model->insert($view)){
                return $this->respondCreated($view);
            } else {
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        /*} catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }*/
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
