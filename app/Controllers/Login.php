<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Modellogin;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Login extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {

        if(!$this->validate([
            'username' => 'required',
            'userpassword' => 'required'
        ])){
            $validation = \Config\Services::validation();

            $response = [
                'status' => 404,
                'error' => true,
                'messages' => $validation->getErrors()
            ];

            return $this->respond($response, 404);
        }else{
            $modelLogin = new Modellogin();
            $username = $this->request->getVar("username");
            $userpassword = $this->request->getVar("userpassword");

            $cekUser = $modelLogin->ceklogin($username);
            if(count($cekUser->getResultArray()) > 0){
                $row = $cekUser->getRowArray();
                $pass_hash = $row['userpassword'];

                if(password_verify($userpassword, $pass_hash)){
                    $issuedate_claim = time();
                    $expired_time = $issuedate_claim + 86400;

                    $token = [
                        'iat' => $issuedate_claim,
                        'exp' => $expired_time
                    ];

                    $token = JWT::encode($token, getenv("TOKEN_KEY"), 'HS256');
                    $output = [
                        'status' => 200,
                        'error' => 200,
                        'messages' => 'Login Successful',
                        'token' => $token,
                        'username' => $username,
                        'email' => $row['useremail'],
                        'noTelepon' => $row['noTelepon']
                    ];

                    return $this->respond($output, 200);
                }else{
                    return $this->failNotFound("Maaf Username atau Password anda salah !!");
                }

            }else{
                return $this->failNotFound("Maaf Username atau Password anda salah !");
            }
        }
    }

}
