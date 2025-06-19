<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PC extends Model
{
    use HasFactory;
    protected $table = 'pc';
    protected $fillable = ['name','price','is_prebuilt','description','img_path'];
    protected $casts = ['is_prebuilt'=>'boolean','price'=>'decimal:2'];

    public $timestamps = true;
    public function components()
    {
        return $this->belongsToMany(Component::class, 'pc_components', 'id_pc', 'id_component')
                    ->withTimestamps();
    }

    public function items()
    {
        return $this->hasMany(PCComponent::class,'id_pc');
    }
    public function refreshPrice(): void
    {
        $total = $this->items()
            ->join('components','components.id','=','pc_components.id_component')
            ->selectRaw('SUM(components.price * pc_components.quantity) as tot')
            ->value('tot') ?? 0;

        $this->update(['price' => $total]);
    }

    public static function random(int $count = 3)
    {
        return self::query()
            ->where('is_prebuilt',1)
            ->inRandomOrder()
            ->take($count)
            ->get();
    }
}
