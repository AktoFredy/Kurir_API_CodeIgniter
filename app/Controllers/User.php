<?php

namespace App\Controllers;

use App\Models\Modeluser;
use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelUsr = new Modeluser();
        $data = $modelUsr->findAll();
        $response = [
            'status' => 200,
            'error' => false,
            'message' => '',
            'totaldata' => count($data),
            'data' => $data,
        ];

        return $this->respond($response, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $modelUsr = new Modeluser();
        $data = $modelUsr ->orLike('idU', $id) 
            ->orLike('username', $id)->get()->getResult();
        
        if(count($data) > 1){
            $response = [
                'status' => 200,
                'error' => "false",
                'message' => '',
                'totaldata' => count($data),
                'data' => $data,
            ];

            return $this->respond($response, 200);
        } else if(count($data) == 1){
            $response = [
                'status' => 200,
                'error' => "false",
                'message' => '',
                'totaldata' => count($data),
                'data' => $data,
            ];

            return $this->respond($response, 200);
        }else{
            return $this->failNotFound('Maaf data user ' . $id . 'tidak ditemukan');
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
        $modelUsr = new Modeluser();
        $email = $this->request->getPost("email");
        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");
        $tanggalLahir = $this->request->getPost("tanggalLahir");
        $noTelepon = $this->request->getPost("noTelepon");

        $modelUsr->insert([
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'tanggalLahir' => $tanggalLahir,
            'noTelepon' => $noTelepon,
        ]);

        $response = [
            'status' => 201,
            'error' => "false",
            'message' => "Data berhasil disimpan"
        ];

        return $this->respond($response, 201);
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
        $modelUsr = new Modeluser();
        $data = [
            'email' => $this->request->getVar("email"),
            'username' => $this->request->getVar("username"),
            'password' => $this->request->getVar("password"),
            'tanggalLahir' => $this->request->getVar("tanggalLahir"),
            'noTelepon' => $this->request->getVar("noTelepon"),
        ];

        $data = $this->request->getRawInput();
        $modelUsr->update($id, $data);
        $reaponse = [
            'status' => 200,
            'error' => null,
            'message' => "Data user dengan id $id berhasil diUpdate"
        ];

        return $this->respond($reaponse);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $modelUsr = new Modeluser();

        $data = $modelUsr->find($id);
        if($data){
            $modelUsr->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => "Data User berhasil dihapus"
            ];

            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound("Data tidak ditemukan");
        }
    }
}
