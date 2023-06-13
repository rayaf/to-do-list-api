<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Task extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'attachment',
        'completed',
        'created_at',
        'completed_at',
        'updated_at',
        'deleted_at',
        'user_id',
    ];

    public static function getValidationRules($taskId = null, $isUpdate = false)
    {
        $rules = [
            'title' => [
                $isUpdate ? 'nullable' : 'required',
                'max:255',
                Rule::unique('tasks')->ignore($taskId),
            ],
            'description' => 'nullable',
            'attachment' => 'nullable|file|max:2048',
            'completed' => 'boolean',
        ];

        return $rules;
    }
}
