<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
//use Mqtt;
//use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\Http;
use Exception;
use Response;
use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;

class Subscriber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:subscribe';

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
     * @return int
     */
    public function handle()
    {
        $topicrec="mqtt/face/2361921/Ack";
        //$client_id = Auth()->user()->id;
        $client_id = 1;
        $mqtt = new Mqtt();

        try{

            $mqtt = MQTT::connection();
            
                $mqtt->subscribe($topicrec, function (string $topic, string $message) {
                    //dd($message);
                    //return response()->json(['errorv2'=> $message]);
                    //dd($message);
                 //$response = json_decode($message, true);
                 \Log::info($message);
                // echo sprintf('Received QoS level 1 message on topic [%s]: %s', $topic, $message);
                    $mqtt->interrupt();
                }, 1);
            
            // Mqtt::ConnectAndSubscribe($topicrec, function($topicrec, $msg){
            //     \Log::info("hello");
            //     echo "Msg Received: \n";
            //     echo "Topic: {$topicrec}\n\n";
            //     echo "\t$msg\n\n";
            //     return $msg;
            // }, $client_id);
            
        }
        catch(Exception $e)
        {
            dd($e->getMessage());
        }
    }
}
