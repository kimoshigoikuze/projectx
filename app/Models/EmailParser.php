<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EmailParser extends Model
{
    use HasFactory;

    public function saveEmailData($emails)
    {
        foreach ($emails as $email) {
            $model = new Email();
            $model->mail_id = $email->getId();
            $model->from = $email->getFrom()->getAddress();
            $model->date = $email->getDate()->format('Y-m-d h:m:s');
            $model->subject = $email->getSubject();
            $model->body = $email->getBodyText();

            foreach ($email->getAttachments() as $attachment) {
                $model->addAttachment($attachment);
            }

            $model->save();
        }
    }

    public function getAttachments($emails)
    {

    }
}
