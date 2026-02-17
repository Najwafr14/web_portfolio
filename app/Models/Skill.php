<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use SoftDeletes;

    protected $table = 'skills';

    // Custom soft delete columns
    const DELETED_AT = 'deleted_at';

    protected $fillable = [
        'name',
        'percentage',
        'category',
        'icon',
        'description',
        'image',
        'display_order',
    ];

    protected $casts = [
        'percentage' => 'integer',
        'display_order' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Boot method untuk handle soft delete
     */
    protected static function boot()
    {
        parent::boot();

        // Set deleted_by saat soft delete
        static::deleting(function ($model) {
            if (!$model->isForceDeleting()) {
                $model->deleted_by = auth()->id();
                $model->saveQuietly(); // Save tanpa trigger event lagi
            }
        });
    }

    /**
     * Scope untuk data aktif (tidak deleted)
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Scope untuk urutkan berdasarkan display_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc');
    }

    /**
     * Scope untuk filter by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get user yang melakukan soft delete
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}