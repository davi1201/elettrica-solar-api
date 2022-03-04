<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PreInspectionAttachments extends Model
{
    protected $fillable = [
        'project_id',
        'file_entry_id',
        'type',
    ];

    public function file()
    {
        return $this->belongsTo(FileEntry::class, 'file_entry_id', 'id');
    }
}
