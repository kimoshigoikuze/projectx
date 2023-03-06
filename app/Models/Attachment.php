<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'mail_id',
        'file_name',
        'attachment_content_text'
    ];

    static public function getUnparsedAttachments() {
        return Attachment::where('attachment_content_text', null)->get();
    }
}
