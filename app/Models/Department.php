<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Department extends Model {
    protected $primaryKey = 'department_id';
    protected $fillable = ['department_name'];
    public function employees() { return $this->hasMany(EmployeeProfile::class,'department_id','department_id'); }

    public function getNameAttribute() {
        return $this->department_name;
    }
}
