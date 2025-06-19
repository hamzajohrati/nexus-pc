<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RequestDetail extends Model
{
    protected $table = 'requests_details';
    protected $fillable = ['id_request','id_component','id_pc','quantity'];

    public $timestamps = true;
    public function request()
    {
        return $this->belongsTo(Requests::class, 'id_request');
    }

    public function component()
    {
        return $this->belongsTo(Component::class, 'id_component');
    }

    public function pc()
    {
        return $this->belongsTo(PC::class, 'id_pc');
    }
}
