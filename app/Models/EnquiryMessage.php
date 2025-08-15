<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Enquiry;
use App\Models\User;

class EnquiryMessage extends Model
{
    use HasFactory;

    protected $fillable = [ 'enquiry_id','sender_id','body' ];

    /**
     * Get the enquiry that the message belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class);
    }

    /**
     * Get the user that sent the message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
