<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class PdfParser extends Model
{
    use HasFactory;

    public function parseEmailAttachments()
    {
        foreach (Attachment::getUnparsedAttachments() as $attachment) {
            $file = Storage::disk('local')->get($attachment->file_name);

            $parser = new Parser();

            $pdf = $parser->parseContent($file);

            $attachment->attachment_content_text = $pdf->getText();
            $attachment->save();

            Storage::delete($attachment->file_name);
        }
    }
}
