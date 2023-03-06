<?php

namespace App\Models;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Mail\Attachment;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'mail_id',
        'body',
        'subject',
        'date',
        'from',
        'parsed'
    ];

    public function addAttachment($attachment)
    {
        $fileName = $attachment->getFilename();
        Storage::disk('local')->put($fileName, $attachment->getDecodedContent());
        $model = new \App\Models\Attachment();
        $model->mail_id = $this->mail_id;
        $model->file_name = $fileName;

        $model->save();
    }
}
