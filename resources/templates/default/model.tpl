<?php

namespace App\Models;

use CodeIgniter\Model;

class {{entity}}Model extends Model
{
    protected $table            = '{{table}}';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = '\\App\\Entities\\{{entity}}';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [{{allowedFields}}];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';

    protected $validationRules = [
        {{rules}}
    ];

    public function getAll()
    {
        return $this->findAll();
    }

    public function getById($id)
    {
        return $this->find($id);
    }

    public function insertData($data)
    {
        return $this->insert($data);
    }

    public function updateData($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteData($id)
    {
        return $this->delete($id);
    }
}
