<?php

namespace App\Controllers;
use App\Models\UsersModel;

class Home extends BaseController
{
    protected $user;

    public function __construct()
    {
        helper(['url']);
        $this->user = new UsersModel();
    }

    public function index(): string
    {
        $data['users'] = $this->user->orderby('id','DESC')->paginate(3,'group1');
        $data['pager'] = $this->user->pager;

        return view('inc/header')
             . view('home', $data)
             . view('inc/footer');
    }

    public function saveUser() {
    $username = $this->request->getVar('username');
    $email = $this->request->getVar('email');

    $this->user->save(["username" => $username, "email" => $email]);

    session()->setFlashdata('success', 'Data inserted successfully');
    return redirect()->to(base_url());
 }
  public function getSingleUser($id){
    $data = $this->user->where('id', $id)->first();
    echo json_encode($data);
}

public function updateUser(){
    $id = $this->request->getVar('updateId');
    $username = $this->request->getVar('username');
    $email = $this->request->getVar('password');

    $data['username'] = $username;
    $data['email'] = $email;

    $this->user->update($id, $data);
    return redirect()->to(base_url("/"));
}
  public function deleteUser() {
    $id = $this->request->getVar('id');
    $this->user->delete($id);
    echo 1;

    // Optionally, you could redirect instead of echoing:
    // return redirect()->to(base_url("/"));
}

}
