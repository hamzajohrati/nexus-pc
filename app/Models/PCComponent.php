<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PCComponent extends Model
{
    protected $table = 'pc_components';
    protected $fillable = ['id_pc','id_component','quantity'];

    public $timestamps = true;
    public function pc()
    {
        return $this->belongsTo(PC::class, 'id_pc');
    }

    public function component()
    {
        return $this->belongsTo(Component::class,'id_component');
    }
}
