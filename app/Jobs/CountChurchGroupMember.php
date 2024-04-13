<?php

namespace App\Jobs;

use App\Models\ChurchGroup;
use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CountChurchGroupMember implements ShouldQueue
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
        $groups = ChurchGroup::all();

        foreach($groups as $group) {
            $group->total_member = $group->members()
                ->where('status', Member::STATUS_ACTIVE)
                ->count();
            $group->save();
        }
    }
}
