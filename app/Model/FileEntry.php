<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FileEntry extends Model
{
    protected $fillable = ['filename', 'mime', 'path'];

    public function urlAttribute()
    {
        return storage_path('files', $this->path);
    }
}