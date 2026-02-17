<?php

/**
 * Utility helper functions for the application
 */

/**
 * Format date to Indonesian locale
 * 
 * @param \Carbon\Carbon|string $date
 * @param string $format
 * @return string
 */
if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'd M Y')
    {
        if (!$date) {
            return '';
        }
        
        try {
            $carbonDate = is_string($date) ? \Carbon\Carbon::parse($date) : $date;
            
            // Indonesian month names
            $months = [
                'Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr',
                'May' => 'Mei', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Agu',
                'Sep' => 'Sep', 'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Des'
            ];
            
            $formatted = $carbonDate->format($format);
            
            foreach ($months as $en => $id) {
                $formatted = str_replace($en, $id, $formatted);
            }
            
            return $formatted;
        } catch (\Exception $e) {
            return '';
        }
    }
}

/**
 * Get file size in human readable format
 * 
 * @param int $bytes
 * @param int $precision
 * @return string
 */
if (!function_exists('formatFileSize')) {
    function formatFileSize($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}

/**
 * Get asset URL for images
 * 
 * @param string $path
 * @return string
 */
if (!function_exists('assetImage')) {
    function assetImage($path)
    {
        if (!$path) {
            return asset('assets/img/placeholder.png');
        }
        
        return asset($path);
    }
}

/**
 * Check if user has permission
 * 
 * @param string $permission
 * @return bool
 */
if (!function_exists('hasPermission')) {
    function hasPermission($permission)
    {
        if (!auth()->check()) {
            return false;
        }
        
        // Simple permission check - can be extended later
        return true;
    }
}
