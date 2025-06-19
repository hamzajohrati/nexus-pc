<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public $table = 'config';
    public $incrementing = false;
    public $primaryKey = null;
    public $timestamps = false;
    protected $guarded = [];
}
