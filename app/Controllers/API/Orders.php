<?php

namespace App\Controllers\API;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class Orders extends ResourceController
{
    protected $modelName = 'App\Models\OrderModel';
    protected $format    = 'json';
    private $upload_path = 'uploads/orders/'; //path for upload
    private $allowed_types = 'pdf'; //restrict extension
    private $max_size = 10240;

    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    }

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
            if($this->jefaturaSession()){
                
                $type = $this->request->getPost('type');
                $year = $this->request->getPost('year'); 
			    $number = $this->request->getPost('number');
			    $name = $type.'_'.$year.'_'.$number.'.pdf';

                $file = $this->request->getFile('file');
                $ext = $file->getClientExtension();
                $size = $file->getSize() / 1024;

                if (! $file->isValid() || $ext != $this->allowed_types || $size > $this->max_size) {
                    return $this->failServerError('No es un archivo valido');
                }

                $date = $this->request->getPost('date');
                $about =  $this->request->getPost('about');
                $path = $this->upload_path . $name;
                $data = [
                    'type' => $type,
                    'number' => $number,
                    'year' => $year,
                    'date' => $date, 
                    'about' => $about, 
                    'file_url' => $path
                ];

                if($this->model->insert($data)){
                    $data['id'] = $this->model->insertID();
                    if ($file->move($this->upload_path, $name)){
                        return $this->respondCreated($data);
                    } else {
                        return $this->failServerError('No se pudo cargar el archivo ');
                    }
                } else {
                    return $this->failValidationErrors($this->model->validation->listErrors());
                }

            } else {
                return $this->failUnauthorized('Acceso no autorizado');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function delete($id = NULL)
    {
        try{
            if($this->jefaturaSession()){
                if($id == NULL){
                    return $this->failValidationErrors('No se ha pasado un ID valido');
                }
                $order = $this->model->find($id);
                if($order == NULL){
                    return $this->failNotFound('No se ha encontrado el usuario con el ID: '.$id);
                }
                if($this->model->delete($id)){
                    $path_to_file = $order['file_url'];
                    !unlink($path_to_file);
                    return $this->respondDeleted($order);
                } else {
                    return $this->failServerError('No se ha podido eliminar el registro');
                }
            } else {
                return $this->failUnauthorized('Acceso no autorizado');
            }   
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    private function jefaturaSession(){
        $session = session();
        return $session->get('user_role') == 'jefatura';
        return true;
    }
}
