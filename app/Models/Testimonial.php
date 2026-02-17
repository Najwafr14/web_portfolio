<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $table = 'testimonials';

    // Custom soft delete columns
    const DELETED_AT = 'deleted_at';

    protected $fillable = [
        'name',
        'position',
        'company',
        'avatar',
        'rating',
        'review_text',
        'is_critic',
        'critic_name',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_critic' => 'boolean',
        'is_active' => 'boolean',
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
        return $query->whereNull('deleted_at')->where('is_active', true);
    }

    /**
     * Scope untuk critic reviews
     */
    public function scopeCritic($query)
    {
        return $query->where('is_critic', true);
    }

    /**
     * Scope untuk personal reviews
     */
    public function scopePersonal($query)
    {
        return $query->where('is_critic', false);
    }

    /**
     * Scope untuk urutkan berdasarkan display_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc');
    }

    /**
     * Scope untuk filter by rating
     */
    public function scopeByRating($query, $minRating = 4)
    {
        return $query->where('rating', '>=', $minRating);
    }

    /**
     * Accessor untuk avatar URL
     */
    public function getAvatarUrlAttribute()
    {
        return $this->avatar 
            ? asset('assets/img/person/' . $this->avatar)
            : asset('assets/img/person/default.jpg');
    }

    /**
     * Accessor untuk star rating HTML
     */
    public function getStarsHtmlAttribute()
    {
        $html = '';
        $fullStars = floor($this->rating);
        $hasHalfStar = ($this->rating - $fullStars) >= 0.5;

        // Full stars
        for ($i = 0; $i < $fullStars; $i++) {
            $html .= '<i class="bi bi-star-fill"></i>';
        }

        // Half star
        if ($hasHalfStar) {
            $html .= '<i class="bi bi-star-half"></i>';
        }

        // Empty stars
        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
        for ($i = 0; $i < $emptyStars; $i++) {
            $html .= '<i class="bi bi-star"></i>';
        }

        return $html;
    }

    /**
     * Get user yang melakukan soft delete
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}