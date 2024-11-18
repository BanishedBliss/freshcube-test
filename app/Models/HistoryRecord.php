<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель записей о действиях и их результатах, лог.
 */
class HistoryRecord extends Model
{
    public $table = 'history_records';
    public $timestamps = false;

    public const array RECORD_TYPES = [
        'contact.create' => 'Создание контакта сделки',
    ];

    protected $fillable = ['action', 'success', 'result', 'created_at'];
}
