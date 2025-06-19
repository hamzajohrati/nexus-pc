<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    use HasFactory;
    protected $table = 'requests';
    public const STATUS = ['pending','in_progress','ready','shipped','delivered','cancelled'];
    protected $fillable = ['id_user','request_type','status','total_price'];
    protected $casts = ['total_price'=>'decimal:2'];

    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function details()
    {
        return $this->hasMany(RequestDetail::class, 'id_request');
    }

    public function mark(string $status): void
    {
        if(!in_array($status,self::STATUS)){
            throw new \InvalidArgumentException('Invalid status');
        }
        $this->update(['status'=>$status]);
    }
}
