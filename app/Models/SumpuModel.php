<?php

namespace App\Models;

use CodeIgniter\Model;

class SumpuModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tourism_village';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id', 'name', 'type_of_tourism', 'address', 'open', 'close', 'ticket_price',
        'contact_person', 'description', 'geom', 'lat', 'lng', 'bank_name', 'bank_code',  'bank_account_holder', 'bank_account_number', 'qr_url'
    ];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // API
    public function get_sumpu()
    {
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $coords = "{$this->table}.lat,{$this->table}.lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.type_of_tourism,{$this->table}.address,{$this->table}.geom,
                        {$this->table}.open,{$this->table}.close,{$this->table}.ticket_price,{$this->table}.contact_person,{$this->table}.description,
                        {$this->table}.bank_name,{$this->table}.bank_code,{$this->table}.bank_account_holder,{$this->table}.bank_account_number,{$this->table}.qr_url";
        $query = $this->db->table($this->table)
            ->select("name as tourism_village_name, {$columns}, {$coords}")
            ->get();
        return $query;

        // $query = $this->db->table($this->table)
        //     ->select('id', 'name', 'type_of_tourism', 'address', 'open', 'close', 'ticket_price', 'contact_person', 'description', 'geom', 'lat', 'lng')
        //     ->where('id', 'SUM01')
        //     ->get();
        // return $query;
    }

    public function get_desa_wisata()
    {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $query = $this->db->table($this->table)
            ->select("id, name, {$coords}")
            ->get();
        return $query;
   
    }
    public function get_desa_wisata_info()
    {
        $query = $this->db->table($this->table)
            ->select("id, name, email")
            ->get();
        return $query;
    }

    public function get_id_province_desa_wisata_info()
    {
        $query = $this->db->table($this->table)
            ->select("province_id, provinsi.name")
            ->join('provinsi', 'tourism_village.province_id = provinsi.id')
            ->get();
        return $query;
    }

    public function get_geoJson($id = null)
    {
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        $query = $this->db->table($this->table)
            ->select("{$geoJson}")
            ->where('id', $id)
            ->get();
        return $query;
    }

    public function get_sumpu_marker($id = null)
    {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}")
            ->where('id', $id)
            ->get();
        return $query;
    }

    public function update_sumpu($id = null, $sumpu = null)
    {
        foreach ($sumpu as $key => $value) {
            if (empty($value)) {
                unset($sumpu[$key]);
            }
        }
        
        $query = $this->db->table($this->table)
            ->where('id', $id)
            ->update($sumpu);
        return $query;
    }
}