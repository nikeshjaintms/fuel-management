<?php

namespace App\Console\Commands;

use App\Models\Fitness;
use App\Models\Policy;
use App\Models\PUC;
use Illuminate\Console\Command;
use Carbon\Carbon;
USE App\Models\Notification;

class CheckExpiryNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:expiry-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check expiry dates and create notifications 10 days before expiry';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now();
        $targetDate = $today->addDays(10);

        // Fetch records expiring in 10 days
        $policyItems = Policy::join('vehicles','policies.vehicle_id','=','vehicles.id')
        ->whereDate('expiry_date', $targetDate)
        ->select('policies.expiry_date','vehicles.vehicle_no')
        ->get();
        $pucItems = PUC::join('vehicles','p_u_c_s.vehicle_id','=','vehicles.id')
        ->whereDate('expiry_date', $targetDate)
        ->select('p_u_c_s.expiry_date','vehicles.vehicle_no')
        ->get();
        $fitnessItems = Fitness::join('vehicles','fitnesses.vehicle_id','=','vehicles.id')
        ->whereDate('expiry_date', $targetDate)
        ->select('fitnesses.expiry_date','vehicles.vehicle_no')
        ->get();

        foreach ($policyItems as $item) {
            Notification::create([
                'title' => 'Policy Expiry Alert',
                'message' => "The policy for {$item->vehicle_no} is expiring on {$item->expiry_date}.",
            ]);
        }
        foreach ($pucItems as $item) {
            Notification::create([
                'title' => 'PUC Expiry Alert',
                'message' => "The PUC for {$item->vehicle_no} is expiring on {$item->expiry_date}.",
            ]);
        }
        foreach ($fitnessItems as $item) {
            Notification::create([
                'title' => 'Fitness Expiry Alert',
                'message' => "The fitness certificate for {$item->vehicle_no} is expiring on {$item->expiry_date}.",
            ]);
        }

        $this->info('Expiry notifications checked.');
    }
}
