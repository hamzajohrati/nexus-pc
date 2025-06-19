<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;
    protected $fillable = ['id_category','name','price','stock','description','img_path'];
    protected $casts = ['price'=>'decimal:2'];

    public $timestamps = true;
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function pcs()
    {
        return $this->belongsToMany(PC::class, 'pc_components', 'id_component', 'id_pc')
                    ->withTimestamps();
    }
}
