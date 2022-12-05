<?php

namespace App\Controllers;

use App\Models\ModelPenerima;
use CodeIgniter\RESTful\ResourceController;

class Penerima extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelPenerima = new ModelPenerima();
        $data = $modelPenerima->findAll();
        $response = [
            'status' => 200,
            'error' => false,
            'message' => '',
            'totaldata' => count($data),
            'data' => $data
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
        $modelPenerima = new ModelPenerima();
        $data = $modelPenerima->orLike('id_penerima', $cari)
            ->orLike('nama_penerima', $cari)->get()->getResult();

        if(count($data) > 1){
            $response = [
                'status' => 200,
                'error' => false,
                'message' => '',
                'totaldata' => count($data),
                'data' => $data
            ];

            return $this->respond($response, 200);
        } else if(count($data) == 1) {
            $response = [
                'status' => 200,
                'error' => false,
                'message' => '',
                'totaldata' => count($data),
                'data' => $data
            ];

            return $this->respond($response, 200);
        }else {
            return $this->failNotFound('Maff data Penerima ' . $cari . ' tidak ditemukan');
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
            'nama_penerima' => 'required',
            'no_hp' => 'required',
            'gender' => 'required',
            'kode_pos' => 'required'
        ])){
            $validation = \Config\Services::validation();

            $response = [
                'status' => 404,
                'error' => true,
                'message' => $validation->getErrors()
            ];

            return $this->respond($response, 404);
        }else{
            $modelPenerima = new ModelPenerima();
            $nama_penerima = $this->request->getPost('nama_penerima');
            $no_hp = $this->request->getPost('no_hp');
            $gender = $this->request->getPost('gender');
            $kode_pos = $this->request->getPost('kode_pos');

            $modelPenerima->insert([
                'nama_penerima' => $nama_penerima,
                'no_hp' => $no_hp,
                'gender' => $gender,
                'kode_pos' => $kode_pos
            ]);

            $response = [
                'status' => 200,
                'error' => false,
                'message' => "Data Penerima berhasil disimpan"
            ];

            return $this->respond($response, 200);
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
        $modelPenerima = new ModelPenerima();
        $data = [
            'nama_penerima' => $this->request->getVar('nama_penerima'),
            'no_hp' => $this->request->getVar('no_hp'),
            'gender' => $this->request->getVar('gender'),
            'kode_pos' => $this->request->getVar('kode_pos'),
        ];

        $data = $this->request->getRawInput();
        $modelPenerima->update($id, $data);
        $response = [
            'status' => 200,
            'error' => false,
            'message' => "Data Penerima dengan id $id berhasil diUpdate"
        ];

        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $modelPenerima = new ModelPenerima();

        $data = $modelPenerima->find($id);
        if($data){
            $modelPenerima->delete($id);
            $response = [
                'status' => 200,
                'error' => false,
                'message' => "Data penerima berhasil dihapus"
            ];

            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound("Data tidak ditemukan");
        }
    }
}
