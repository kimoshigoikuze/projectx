<?php

namespace App\Jobs;

use App\Models\EmailParser;
use App\Models\EmailReader;
use App\Models\PdfParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;

class HandleUnseenMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $reader = new EmailReader();
        $messages = $reader->getUnseenMails();

        $parser = new EmailParser();
        $parser->saveEmailData($messages);

        $reader->setEmailsAsSeen($messages);

        $pdfParser = new PdfParser();
        $pdfParser->parseEmailAttachments();

        $reader->closeConnection();
    }
}
