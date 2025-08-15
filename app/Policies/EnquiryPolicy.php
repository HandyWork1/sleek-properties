<?php

namespace App\Policies;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnquiryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the given enquiry.
     */
    public function view(User $user, Enquiry $enquiry): bool
    {
        // Only sender or recipient may view
        return in_array($user->id, [
            $enquiry->from_user_id,
            $enquiry->to_user_id,
        ]);
    }

    /**
     * Determine whether the user can reply to the given enquiry.
     */
    public function reply(User $user, Enquiry $enquiry): bool
    {
        // Only the original recipient (agent) may reply
        // or, if you’d like both parties to reply, you could:
        return in_array($user->id, [$enquiry->from_user_id, $enquiry->to_user_id]);
        // return $user->id === $enquiry->to_user_id;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Enquiry $enquiry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Enquiry $enquiry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Enquiry $enquiry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Enquiry $enquiry): bool
    {
        return false;
    }
}
