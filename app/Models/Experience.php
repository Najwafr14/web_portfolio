<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Experience extends Model
{
    use SoftDeletes;

    protected $table = 'experiences';

    // Custom soft delete columns
    const DELETED_AT = 'deleted_at';

    protected $fillable = [
        'position',
        'company',
        'start_date',
        'end_date',
        'description',
        'achievements',
        'is_current',
        'display_order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'achievements' => 'array', // JSON array
        'is_current' => 'boolean',
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
     * Scope untuk pengalaman yang sedang aktif
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    /**
     * Scope untuk urutkan berdasarkan tanggal
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('start_date', 'desc');
    }

    /**
     * Accessor untuk format tanggal
     */
    public function getDateRangeAttribute()
    {
        $start = $this->start_date->format('M Y');
        $end = $this->is_current ? 'Present' : $this->end_date->format('M Y');
        
        return "{$start} - {$end}";
    }

    /**
     * Accessor untuk durasi kerja
     */
    public function getDurationAttribute()
    {
        $start = $this->start_date;
        $end = $this->is_current ? now() : $this->end_date;
        
        $diff = $start->diff($end);
        $years = $diff->y;
        $months = $diff->m;
        
        if ($years > 0 && $months > 0) {
            return "{$years} years {$months} months";
        } elseif ($years > 0) {
            return "{$years} years";
        } else {
            return "{$months} months";
        }
    }

    /**
     * Get user yang melakukan soft delete
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}