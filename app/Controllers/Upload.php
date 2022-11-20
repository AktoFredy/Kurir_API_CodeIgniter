<?php

namespace App\Controllers;

use App\Models\Modeluser;
use CodeIgniter\RESTful\ResourceController;

class Upload extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
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
        //
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
    public function update($idU = null)
    {
        $modelUsr = new Modeluser();

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'userfoto' => [
                'label' => 'File Image',
                'rules' => 'uploaded[userfoto]|is_image[userfoto]|ext_in[userfoto,png,jpg,jpeg,gif]|mime_in[userfoto,image/png,image/jpg,image/jpeg,image/gif]',
                'errors' => [
                    'uploaded' => '{field} Wajib Upload',
                    'mime_in' => '{field} Kesalahan Mime'
                ]
            ]
        ]);

        if(!$valid){
            $error_msg = [
                'err_upload' => $validation->getError('userfoto')
            ];

            $response = [
                'status' => 404,
                'error' => true,
                'message' => $error_msg
            ];

            return $this->respond($response, 404);
        }else{
            $cekImg = $modelUsr->find($idU);
            if($cekImg['userfoto'] != null || $cekImg['userfoto'] != ""){
                unlink('uploads/'.$cekImg['userfoto']);
            }

            $img = $this->request->getFile('userfoto');

            if(!$img->hasMoved()){
                $img->move('uploads',$idU.'.'.$img->getExtension());
            }

            $data = [
                'userfoto' => $img->getName()
            ];

            $modelUsr->update($idU, $data);

            $response = [
                'status' => 201,
                'error' => false,
                'message' => 'Upload Foto User Berhasil'
            ];

            return $this->respond($response, 201);
        }
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
