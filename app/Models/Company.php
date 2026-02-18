<?php

namespace App\Models;

use App\Traits\HistoryTrait;
use App\Traits\SoftDeleteTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Company extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    // Coment this code if using soft delete
    use SoftDeleteTrait;

    // Coment this code if using history
    use HistoryTrait;

    protected $connection = 'pgsql';
    protected $table = 'company';

    protected $primaryKey = 'company_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = ['is_removed',];
    protected $casts = ['is_removed' => 'boolean',];

    protected $fillable = [
        'company_id',
        'status',
        'is_removed',
    ];
}
