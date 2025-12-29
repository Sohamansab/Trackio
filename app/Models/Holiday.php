<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model {
    protected $primaryKey = 'holiday_id';
    protected $fillable = ['title','date'];
    public $timestamps = true;
}
