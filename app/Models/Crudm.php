<?php
namespace App\Models;
use CodeIgniter\Model;
class Crudm extends Model{
    protected $table = "crud";
    public function createUser($data){
        $builder = $this->db->table('crud');
        $res = $builder->insert($data);
        if($this->db->affectedRows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function disp($off_set,$per_page){
        $db = \Config\Database::connect();
        $query = $db->query("select * from crud LIMIT {$per_page} OFFSET {$off_set}");
        $result = $query->getResultArray();
        if(count($result) > 0){
            return $result;
        }
        else{
            return false;
        }
    }
    public function fetch($eid){
        $builder = $this->db->table('crud');
        $builder->select('id');
        $builder->where('Email',$eid);
        $res = $builder->get();
    if(count($res->getResultArray()) > 0){
        return $res->getRowArray();
    }
    else{
        return false;
    }
}
public function finalEdit($id,$data){
    $builder = $this->db->table('crud');
    $builder->where('id',$id);
    $builder->update($data);
    if($this->db->affectedRows() == 1){
        return true;
    }
    else{
        return false;
    }
}
public function del($id){
    $builder = $this->db->table("crud");
    $builder->where('id',$id);
    $builder->delete();
    $builder->get();
}
public function fetchEmail($id){
    $builder = $this->db->table('crud');
    $builder->select('Email');
    $builder->where('id',$id);
    $res = $builder->get();
if(count($res->getResultArray()) > 0){
    return $res->getRowArray();
}
else{
    return false;
}
}
public function getUpdate($id){
    $builder = $this->db->table("crud");
    $builder->select('id','Name','Email','phone','City','Age');
    $builder->where('id',$id);
    $res = $builder->getResult();
if(count($res->getResultArray()) > 0){
    return $res->getRowArray();
}
else{
    return "HELLO!";
}
}
public function getRowCount()
{
    $db = \Config\Database::connect();
    $table = 'crud';
    $count = $db->table($table)->countAllResults();
    return $count;
}
public function searcH($que){
$builder = $this->db->table('crud');
$builder->select('*');
if($que !=''){
    $builder->like('Name',$que);
    $builder->orlike('Email',$que);
    $builder->orlike('phone',$que);
    $builder->orlike('City',$que);
    $builder->orlike('Age',$que);
}
$query = $builder->get();
return $query->getResultArray();
}
}