<?php

namespace App\Console\Commands;
use App\Models\RTOTaxPayment;
use App\Models\Vehicles;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateRTOTaxPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rto:generate-tax';
    protected $description = 'Generate RTO tax payment entries for all vehicles every month';

    /**
     * The console command description.
     *
     * @var string
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $vehicles = Vehicles::all(); // Assuming you have a Vehicle model

        foreach ($vehicles as $vehicle) {
            // Check if entry already exists for this month and vehicle
            $existingEntry = RTOTaxPayment::where('vehicle_id', $vehicle->id)
                ->where('month', Carbon::now()->format('M'))
                ->where('year', Carbon::now()->format('Y'))
                ->exists();

            if (!$existingEntry) {
                RTOTaxPayment::create([
                    'vehicle_id' => $vehicle->id,
                    'month' => Carbon::now()->format('M'),
                    'year' => Carbon::now()->format('Y'),
                    'status' => 'Pending'
                ]);
            }
        }

        $this->info('RTO tax payment records generated successfully.');
    }
}
