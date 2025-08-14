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

    protected $casts = [
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
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

     // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where(function($q) use ($userId) {
            $q->where('to_user_id', $userId)
              ->orWhere('from_user_id', $userId);
        });
    }

    // Helpers
    public function latestMessage()
    {
        return $this->messages()->latest()->first();
    }

    public function repliesCount(): int
    {
        return $this->messages()->count();
    }

    public function isUnreadFor(int $userId): bool
    {
        // if current user is recipient and read_at null => unread
        if ($this->to_user_id === $userId) {
            return is_null($this->read_at);
        }

        // Sent items should not be considered unread for sender
        return false;
    }

    public function markReadFor(int $userId): bool
    {
        if ($this->to_user_id === $userId && is_null($this->read_at)) {
            $this->update(['read_at' => now(), 'status' => $this->status === 'unread' ? 'read' : $this->status]);
            return true;
        }
        return false;
    }

    public function markReplied(): void
    {
        $this->update(['replied_at' => now(), 'status' => 'replied']);
    }
}
