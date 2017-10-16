<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSentLog extends Model
{
    protected $table = TBL_EMAIL_SENT;

    protected $fillable = ['to_email','cc_emails','bcc_emails','from_email','email_subject','email_body','mail_response','status'];

    public $timestamps = true;

}
