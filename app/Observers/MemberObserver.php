<?php

namespace App\Observers;

use App\Jobs\CountChurchGroupMember;
use App\Jobs\CountFamilyMember;
use App\Models\Member;

class MemberObserver
{
    /**
     * Handle the Member "created" event.
     */
    public function created(): void
    {
        CountFamilyMember::dispatch();
        CountChurchGroupMember::dispatch();
    }

    /**
     * Handle the Member "updated" event.
     */
    public function updated(): void
    {
        CountFamilyMember::dispatch();
        CountChurchGroupMember::dispatch();
    }

    /**
     * Handle the Member "deleted" event.
     */
    public function deleted(): void
    {
        CountFamilyMember::dispatch();
        CountChurchGroupMember::dispatch();
    }

    /**
     * Handle the Member "restored" event.
     */
    public function restored(): void
    {
        CountFamilyMember::dispatch();
        CountChurchGroupMember::dispatch();
    }

    /**
     * Handle the Member "force deleted" event.
     */
    public function forceDeleted(): void
    {
        CountFamilyMember::dispatch();
        CountChurchGroupMember::dispatch();
    }
}
