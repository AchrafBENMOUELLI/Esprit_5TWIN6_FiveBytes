<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProjectDocument extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'titre',
        'chemin_fichier',
        'type',
    ];

    /**
     * Get the project that owns the document.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Get the file extension from the file path.
     *
     * @return string
     */
    public function getFileExtension(): string
    {
        return pathinfo($this->chemin_fichier, PATHINFO_EXTENSION);
    }

    /**
     * Get the file size in bytes (returns 0 if file doesn't exist).
     *
     * @return int
     */
    public function getFileSize(): int
    {
        if (Storage::exists($this->chemin_fichier)) {
            return Storage::size($this->chemin_fichier);
        }
        return 0;
    }

    /**
     * Get the file size formatted in human-readable format.
     *
     * @return string
     */
    public function getFileSizeFormatted(): string
    {
        $bytes = $this->getFileSize();
        
        if ($bytes === 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = floor(log($bytes, 1024));
        
        return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
    }

    /**
     * Get the full URL to download the document.
     *
     * @return string
     */
    public function getDownloadUrl(): string
    {
        return Storage::url($this->chemin_fichier);
    }

    /**
     * Check if the file exists.
     *
     * @return bool
     */
    public function fileExists(): bool
    {
        return Storage::exists($this->chemin_fichier);
    }

    /**
     * Get the document type label in French.
     *
     * @return string
     */
    public function getTypeLabel(): string
    {
        $labels = [
            'rapport' => 'Rapport',
            'photo' => 'Photo',
            'facture' => 'Facture',
            'contrat' => 'Contrat',
            'plan' => 'Plan',
            'autre' => 'Autre',
        ];

        return $labels[$this->type] ?? $this->type;
    }

    /**
     * Get the icon class based on file extension.
     *
     * @return string
     */
    public function getIconClass(): string
    {
        $extension = strtolower($this->getFileExtension());
        
        $iconMap = [
            'pdf' => 'fa-file-pdf',
            'doc' => 'fa-file-word',
            'docx' => 'fa-file-word',
            'xls' => 'fa-file-excel',
            'xlsx' => 'fa-file-excel',
            'jpg' => 'fa-file-image',
            'jpeg' => 'fa-file-image',
            'png' => 'fa-file-image',
            'gif' => 'fa-file-image',
            'zip' => 'fa-file-archive',
            'rar' => 'fa-file-archive',
            'txt' => 'fa-file-alt',
        ];

        return $iconMap[$extension] ?? 'fa-file';
    }
}
