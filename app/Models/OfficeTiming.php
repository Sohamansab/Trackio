<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OfficeTiming extends Model {
    protected $primaryKey = 'office_timing_id';
    protected $fillable = ['start_time','end_time','break_minutes','grace_minutes'];
}
