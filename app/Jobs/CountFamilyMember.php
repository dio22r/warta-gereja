<?php

namespace App\Jobs;

use App\Models\Family;
use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CountFamilyMember implements ShouldQueue
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
        $families = Family::all();

        foreach($families as $family) {
            $family->total_member = $family->members()
                ->where('status', Member::STATUS_ACTIVE)
                ->count();
            $family->save();
        }
    }
}
