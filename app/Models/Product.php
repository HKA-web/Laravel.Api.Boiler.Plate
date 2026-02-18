<?php

namespace App\Models;

use App\Traits\HistoryTrait;
use App\Traits\SoftDeleteTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    // Coment this code if using soft delete
    use SoftDeleteTrait;

    // Coment this code if using history
    use HistoryTrait;

    protected $connection = 'pgsql';
    protected $table = 'product';

    protected $primaryKey = 'product_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = ['is_removed',];
    protected $casts = ['is_removed' => 'boolean',];

    protected $fillable = [
        'product_id',
        'status',
        'is_removed',
    ];
}