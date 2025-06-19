<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['category','color','icon','description'];
    
    public $timestamps = true;
    public function components()
    {
        return $this->hasMany(Component::class, 'id_category');
    }
}
