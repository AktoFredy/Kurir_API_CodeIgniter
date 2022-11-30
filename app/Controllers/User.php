<?php

namespace App\Controllers;

use App\Models\Modeluser;
use CodeIgniter\HTTP\Response;
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
    public function show($cari = null)
    {
        $modelUsr = new Modeluser();
        $data = $modelUsr ->orLike('idU', $cari) 
            ->orLike('username', $cari)->get()->getResult();
        
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
            return $this->failNotFound('Maaf data user ' . $cari . 'tidak ditemukan');
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
        if(!$this->validate([
            'useremail' => 'required|valid_email',
            'username' => 'required|is_unique[users.username]',
            'userpassword' => 'required',
            'confirmpassword' => 'required|matches[userpassword]',
            'tanggalLahir' => 'required|valid_date[Y-m-d]',
            'noTelepon' => 'required|numeric|min_length[10]|max_length[13]'
        ])){
            $validation = \Config\Services::validation();

            $response = [
                'status' => 404,
                'error' => true,
                'message' => $validation->getErrors()
            ];

            return $this->respond($response, 404);
        }else{
            $modelUsr = new Modeluser();
            $useremail = $this->request->getPost("useremail");
            $username = $this->request->getPost("username");
            $userpassword = $this->request->getPost("userpassword");
            $tanggalLahir = $this->request->getPost("tanggalLahir");
            $noTelepon = $this->request->getPost("noTelepon");

            $opt = [
                'cost' => 10,
            ];

            $modelUsr->insert([
                'useremail' => $useremail,
                'username' => $username,
                'userpassword' => password_hash($userpassword, PASSWORD_DEFAULT, $opt),
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

        $opt = [
            'cost' => 10,
        ];

        $data = [
            'useremail' => $this->request->getVar("useremail"),
            'username' => $this->request->getVar("username"),
            'userpassword' => $this->request->getVar("userpassword"),
            'tanggalLahir' => $this->request->getVar("tanggalLahir"),
            'noTelepon' => $this->request->getVar("noTelepon"),
        ];

        $data = $this->request->getRawInput();
        $password = password_hash($data['userpassword'], PASSWORD_DEFAULT, $opt);
        $data['userpassword'] = $password;
        
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
