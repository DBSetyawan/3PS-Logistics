<?php

namespace warehouse\Jobs;

use File;
use League\Csv\Reader;
use Illuminate\Bus\Queueable;
use warehouse\Models\Customer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportCustomerJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $filename;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $csv = Reader::createFromPath(storage_path('app/public/import/' . $this->filename), 'r');
        $csv->setHeaderOffset(0);
        
        foreach ($csv as $row) {
            Customer::create([
                'itemID_accurate' => "CS021091010011",
                'company_id' => 29,
                'project_id' => $row["ID Pelanggan Izzy"],
                'name' => $row["Nama"],
                'customerTaxType' => $row["Tipe Pajak"],
                'customer_id' => $row["ID Pelanggan"],
                'email' => $row["Email"],
                'tax_no' => $row["NPWP"],
                'PNGHN_alamat' => $row["Alamat Penagihan"],
                'tax_address' => $row["Alamat (Pajak)"],
                'address' => $row["Alamat Pengiriman"],
                'city_id' => 1204,
                'bank_name' => "",
                'no_rek' => "",
                'an_bank' => "",
                'term_of_payment' => 1,
                'status_id' => 1
            ]);
        }
        File::delete(storage_path('app/public/import/' . $this->filename));
    }
}
