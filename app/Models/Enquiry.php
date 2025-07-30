<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Property;
use App\Models\User;
use App\Models\EnquiryMessage;    

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id','from_user_id','to_user_id',
        'subject','status','read_at','replied_at'
    ];

    /**
     * Get the property associated with the enquiry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the user who sent the enquiry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /**
     * Get the user who received the enquiry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    /**
     * Get all of the enquiry messages for the enquiry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(EnquiryMessage::class);
    }
}
