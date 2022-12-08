<?php

namespace App\Controllers;

use App\Models\ModelFaq;
use CodeIgniter\RESTful\ResourceController;

class Faq extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelFaq = new ModelFaq();
        $data = $modelFaq->findAll();
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
        $modelFaq = new ModelFaq();

        $data = $modelFaq->orLike('id', $cari)
            ->orLike('question', $cari)->get()->getResult();

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
            return $this->failNotFound('Maaf ' . $cari . ' tidak ditemukan');
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
