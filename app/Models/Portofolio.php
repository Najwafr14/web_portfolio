<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portofolio extends Model
{
    use SoftDeletes;

    protected $table = 'portfolios';

    // Custom soft delete columns
    const DELETED_AT = 'deleted_at';

    protected $fillable = [
        'title',
        'category',
        'description',
        'image',
        'project_url',
        'tags',
        'is_featured',
        'display_order',
    ];

    protected $casts = [
        'tags' => 'array', // JSON array
        'is_featured' => 'boolean',
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
                $model->saveQuietly();
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
     * Scope untuk featured portfolio
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
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
     * Scope untuk search by tag
     */
    public function scopeByTag($query, $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }

    /**
     * Accessor untuk image URL
     */
    public function getImageUrlAttribute()
    {
        return $this->image 
            ? asset('assets/img/portfolio/' . $this->image)
            : asset('assets/img/portfolio/default.jpg');
    }

    /**
     * Get user yang melakukan soft delete
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}