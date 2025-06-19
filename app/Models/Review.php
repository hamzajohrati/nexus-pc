<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['id_user','id_request','review'];

    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function request()
    {
        return $this->belongsTo(Requests::class, 'id_request');
    }
}
