<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BiometricDevice extends Model {
    protected $primaryKey = 'device_id';
    protected $fillable = ['device_name','location'];
    public function logs() { return $this->hasMany(BiometricLog::class,'device_id','device_id'); }
}
