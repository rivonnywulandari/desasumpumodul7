<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryEventModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'gallery_event';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields    = ['id', 'event_id', 'url'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function get_gallery($event_id = null)
    {
        $query = $this->db->table($this->table)
            ->select('url')
            ->where('event_id', $event_id)
            ->get();
        return $query;
    }

    public function get_new_id()
    {
        $lastId = $this->db->table($this->table)->select('id')->orderBy('id', 'ASC')->get()->getLastRow('array');
        if(empty($lastId)){
            $id='GE001';
        }else{
        $count = (int)substr($lastId['id'], 3);
        $id = sprintf('GE%03d', $count + 1);
        }
        return $id;
    }

    public function add_new_gallery($id = null, $data = null)
    {
        $query = false;
        foreach ($data as $gallery) {
            $new_id = $this->get_new_id();
            $content = [
                'id' => $new_id,
                'event_id' => $id,
                'url' => $gallery,
                // 'created_at' => Time::now(),
                // 'updated_at' => Time::now(),
            ];
            $query = $this->db->table($this->table)->insert($content);
        }
        return $query;
    }

    public function update_gallery($id = null, $data = null)
    {
        $queryDel = $this->delete_gallery($id);

        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }
        $queryIns = $this->add_new_gallery($id, $data);
        return $queryDel && $queryIns;
    }

    public function delete_gallery($id = null)
    {
        return $this->db->table($this->table)->delete(['event_id' => $id]);
    }
}
