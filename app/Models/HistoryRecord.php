<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryRecord extends Model
{
    public $table = 'history_records';

    public const array RECORD_TYPES = [
        'contact.create' => 'Создание контакта сделки',
    ];

    protected $fillable = ['action', 'success', 'result', 'created_at'];
}
