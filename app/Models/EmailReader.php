<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ddeboer\Imap\Server;
use Ddeboer\Imap\Search\Flag\Unseen;
class EmailReader extends Model
{
    use HasFactory;

    private $inbox;
    private $server;
    protected $connection;

    public function __construct()
    {
        $server = new Server(env('MAIL_INCOMING_HOST'));
        $this->connection = $server->authenticate(env('MAIL_INCOMING_USER'), env('MAIL_INCOMING_PASS'));
    }

    public function getUnseenMails()
    {
        return $this->connection->getMailbox('INBOX')->getMessages(new Unseen());
    }

    public function setEmailsAsSeen($emails)
    {
        if(count($emails) !== 0) foreach ($emails as $email) $email->markAsSeen();
    }

    public function closeConnection()
    {
        unset($this->server);
        unset($this->connection);
    }
}
