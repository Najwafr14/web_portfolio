<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    use SoftDeletes;

    protected $table = 'educations';

    // Custom soft delete columns
    const DELETED_AT = 'deleted_at';

    protected $fillable = [
        'degree',
        'institution',
        'start_year',
        'end_year',
        'description',
        'display_order',
    ];

    protected $casts = [
        'start_year' => 'integer',
        'end_year' => 'integer',
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
     * Scope untuk urutkan berdasarkan tahun
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('start_year', 'desc');
    }

    /**
     * Accessor untuk year range
     */
    public function getYearRangeAttribute()
    {
        if ($this->start_year == $this->end_year) {
            return (string) $this->start_year;
        }
        
        return "{$this->start_year} - {$this->end_year}";
    }

    /**
     * Get user yang melakukan soft delete
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}