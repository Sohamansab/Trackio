<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model {
    protected $primaryKey = 'audit_id';
    protected $fillable = ['user_id','action','timestamp','description'];
    public $timestamps = false;
    public function user() { return $this->belongsTo(User::class,'user_id','user_id'); }
}
