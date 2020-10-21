<?php

namespace App\Console\Commands;

use App\Models\Settings;
use Illuminate\Console\Command;

class updateCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $code = 'JPY';

        //http://free.currencyconverterapi.com/api/v5/convert?q=USD_INR&compact=y
        $url = "http://free.currencyconverterapi.com/api/v5/convert?q=USD_" . $code . "&compact=y&apiKey=fdada0e49c08b5e2c96b";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        if ($response === FALSE) {
            print_r($response);
            die;
        }

        curl_close($ch);

        $response = json_decode($response);

        $finalAmount = $response->USD_JPY->val;

        $settings = Settings::first();
        $settings->update(['yen_rate' => $finalAmount]);
        die;
    }
}
