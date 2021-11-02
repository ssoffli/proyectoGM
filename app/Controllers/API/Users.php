<?php

namespace App\Controllers\API;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    public function index()
    {
        try{  
            return $this->respond($this->model->findAll());
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function create()
    {
        try {
            $user = $this->request->getJSON();
            if($this->model->insert($user)){
                $user->id = $this->model->insertID();
                return $this->respondCreated($user);
            } else {
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function edit($id = NULL)
    {
        try {
            if($id == NULL){
                return $this->failValidationErrors('No se ha pasado un ID valido');
            }
            $user = $this->model->find($id);
            if($user == NULL){
                return $this->failNotFound('No se ha encontrado el usuario con el ID: '.$id);
            }
            return $this->respond($user);
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function update($id = NULL)
    {
        try {
            if($id == NULL){
                return $this->failValidationErrors('No se ha pasado un ID valido');
            }
            $userCheck = $this->model->find($id);
            if($userCheck == NULL){
                return $this->failNotFound('No se ha encontrado el usuario con el ID: '.$id);
            }
            $user = $this->request->getJSON();
            if($this->model->update($id,$user)){
                $user->id = $id;
                return $this->respondUpdated($user);
            } else {
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function delete($id = NULL)
    {
        try {
            if($id == NULL){
                return $this->failValidationErrors('No se ha pasado un ID valido');
            }
            $user = $this->model->find($id);
            if($user == NULL){
                return $this->failNotFound('No se ha encontrado el usuario con el ID: '.$id);
            }
            if($this->model->delete($id)){
                return $this->respondDeleted($user);
            } else {
                return $this->failServerError('No se ha podido eliminar el registro');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function login(){
        try{
            $data = $this->request->getJSON();
            $nick = $data->nick;
            $pass = $data->pass;
            return $this->respond($this->model->login($nick, $pass));
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function logout(){

    }
}
