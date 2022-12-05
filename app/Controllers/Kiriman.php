<?php

namespace App\Controllers;

use App\Models\ModelKiriman;
use App\Models\Modelpengiriman;
use CodeIgniter\RESTful\ResourceController;

class Kiriman extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelKiriman = new ModelKiriman();
        $data = $modelKiriman->findAll();
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
        $modelKiriman = new ModelKiriman();
        $data = $modelKiriman->orLike('id_kiriman', $cari)
            ->orLike('nama_barang', $cari)->get()->getResult();

        if(count($data) > 1){
            $response = [
                'status' => 200,
                'error' => false,
                'message' => '',
                'totaldata' => count($data),
                'data' => $data
            ];
    
            return $this->respond($response, 200);
        }else if(count($data) == 1){
            $response = [
                'status' => 200,
                'error' => false,
                'message' => '',
                'totaldata' => count($data),
                'data' => $data
            ];
    
            return $this->respond($response, 200);
        }else{
            return $this->failNotFound('Maaf data Kiriman' . $cari . ' tidak ditemukan');
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
            'nama_barang' => 'required',
            'berat' => 'required',
            'pecah_belah' => 'required',
            'cover' => 'required',
            'asuransi' => 'required'
        ])){
            $validation = \Config\Services::validation();

            $response = [
                'status' => 404,
                'error' => true,
                'message' => $validation->getErrors()
            ];

            return $this->respond($response, 404);
        }else{
            $modelKiriman = new ModelKiriman();
            $nama_barang = $this->request->getPost('nama_barang');
            $berat = $this->request->getPost('berat');
            $pecah_belah = $this->request->getPost('pecah_belah');
            $cover = $this->request->getPost('cover');
            $asuransi = $this->request->getPost('asuransi');

            $modelKiriman->insert([
                'nama_barang' => $nama_barang,
                'berat' => $berat,
                'pecah_belah' => $pecah_belah,
                'cover' => $cover,
                'asuransi' => $asuransi
            ]);

            $response = [
                'status' => 200,
                'error' => false,
                'message' => "Data Kiriman berhasil disimpan"
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
        $modelKiriman = new ModelKiriman();
        $data = [
            'nama_barang' => $this->request->getVar('nama_barang'),
            'berat' => $this->request->getVar('berat'),
            'pecah_belah' => $this->request->getVar('pecah_belah'),
            'cover' => $this->request->getVar('cover'),
            'asuransi' => $this->request->getVar('asuransi')
        ];

        $data = $this->request->getRawInput();
        $modelKiriman->update($id, $data);

        $response = [
            'status' => 200,
            'error' => false,
            'message' => "Data Kiriman dengan $id berhasil diupdate"
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
        $modelKiriman = new ModelKiriman();
        $data = $modelKiriman->find($id);

        if($data){
            $modelKiriman->delete($id);
            $response = [
                'status' => 200,
                'error' => false,
                'message' => "Data Kiriman berhasil dihapus"
            ];

            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound("Data tidak ditemukan");
        }
    }
}
