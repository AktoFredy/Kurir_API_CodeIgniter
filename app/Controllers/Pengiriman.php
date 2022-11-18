<?php

namespace App\Controllers;

use App\Models\Modelpengiriman;
use CodeIgniter\RESTful\ResourceController;

class Pengiriman extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelPngr = new Modelpengiriman();
        $data = $modelPngr->findAll();
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
        $modelPngr = new Modelpengiriman();
        $data = $modelPngr ->orLike('idP', $cari) 
            ->orLike('namaPengirim', $cari)->get()->getResult();
        
        if(count($data) > 1){
            $response = [
                'status' => 200,
                'error' => false,
                'message' => '',
                'totaldata' => count($data),
                'data' => $data,
            ];

            return $this->respond($response, 200);
        } else if(count($data) == 1){
            $response = [
                'status' => 200,
                'error' => false,
                'message' => '',
                'totaldata' => count($data),
                'data' => $data,
            ];

            return $this->respond($response, 200);
        }else{
            return $this->failNotFound('Maaf data Pengiriman ' . $cari . 'tidak ditemukan');
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
        $modelPngr = new Modelpengiriman();
        $namaPengirim = $this->request->getPost("namaPengirim");
        $namaPenerima = $this->request->getPost("namaPenerima");
        $desBarang = $this->request->getPost("desBarang");
        $kotaAsal = $this->request->getPost("kotaAsal");
        $kotaTujuan = $this->request->getPost("kotaTujuan");
        $alamatLengkap = $this->request->getPost("alamatLengkap");
        $ongkos = $this->request->getPost("ongkos");

        $modelPngr->insert([
            'namaPengirim' => $namaPengirim,
            'namaPenerima' => $namaPenerima,
            'desBarang' => $desBarang,
            'kotaAsal' => $kotaAsal,
            'kotaTujuan' => $kotaTujuan,
            'alamatLengkap' => $alamatLengkap,
            'ongkos' => $ongkos,
        ]);

        $response = [
            'status' => 201,
            'error' => false,
            'message' => "Data pengiriman berhasil disimpan"
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
        $modelPngr = new Modelpengiriman();
        $data = [
            'namaPengirim' => $this->request->getVar("namaPengirim"),
            'namaPenerima' => $this->request->getVar("namaPenerima"),
            'desBarang' => $this->request->getVar("desBarang"),
            'kotaAsal' => $this->request->getVar("kotaAsal"),
            'kotaTujuan' => $this->request->getVar("kotaTujuan"),
            'alamatLengkap' => $this->request->getVar("alamatLengkap"),
            'ongkos' => $this->request->getVar("alamatLengkap"),
        ];

        $data = $this->request->getRawInput();
        $modelPngr->update($id, $data);
        $reaponse = [
            'status' => 200,
            'error' => null,
            'message' => "Data pengiriman dengan id $id berhasil diUpdate"
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
        $modelPngr = new Modelpengiriman();

        $data = $modelPngr->find($id);
        if($data){
            $modelPngr->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => "Data pengiriman berhasil dihapus"
            ];

            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound("Data tidak ditemukan");
        }
    }
}
