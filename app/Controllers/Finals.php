<?php

namespace App\Controllers;
use App\Models\Crudm;

class Finals extends BaseController{
    public $cm;
    public function __construct(){
        $this->cm = new Crudm();
    }
    public function index(){
      return view('crudview3');
    }
    public function Fadd(){
        $uniid = md5(str_shuffle('abcdefghijklmnopqrstuvwxyz'.time()));
       
            $record = [
                'Name' => $this->request->getPost('name'),
                'Email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'City' => $this->request->getPost('city'),
                'Age' => $this->request->getPost('age'),
                'id' => $uniid
            ];
            $this->cm->createUser($record);
            $message = "Data Saved Successfully!";
            return json_encode($message);
        }

        public function Fread(){
    //         $output = '';
            $per_page = 5;
            $page = "";
      if(isset($_POST["page_no"])){
        $page = $_POST["page_no"];
      }else{
        $page = 1;
      }
            $total_records = $this->cm->getRowCount();
            $data['total_link'] = ceil($total_records/$per_page);
            $off_set = ($page - 1) * $per_page;
            $data['view'] = $this->cm->disp($off_set,$per_page);
           return json_encode($data);
        }

    public function Fupdate(){
            $dataID = $this->request->getPost('id');
            $data = [
                'Name' => $this->request->getPost('name'),
                'Email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'City' => $this->request->getPost('city'),
                'Age' => $this->request->getPost('age')
            ];
            if($this->cm->finalEdit($dataID,$data)){
                $message = "Data Updated Successfully! :)";
            }
            else{
                $message = "Data not Updated! :(";
            }
            return json_encode($message);
        }
        public function Fdel(){
            $data['uniid'] = $this->request->getPost('id');
            if($this->cm->del($data['uniid'])){
                $data['success'] = 1;
            }
            else{
                $data['success'] = 2;
            }
            return json_encode($data);
        }
        public function searchh(){
            $query = '';
  if(isset($_POST["query"])){
      $query = $_POST["query"];
  }
  $data = $this->cm->searcH($query);
 return json_encode($data);
 }
    }