<?php

namespace App\Console\Commands;

use App\Models\Freezer;
use Illuminate\Console\Command;
use Bluerhinos\phpMQTT;
use App\Models\Leitura;
use Illuminate\Support\Facades\Log;
use App\Services\TelegramService;

class MqttListener extends Command
{
    protected $signature = 'mqtt:listen';
    protected $description = 'Escuta mensagens MQTT e salva no banco';

    public function handle()
    {
        $server = 'dd31ad1d.ala.dedicated.aws.emqxcloud.com'; // ou IP do EMQX
        $port = 1883;
        $username = 'laravel'; // se houver
        $password = 'laravel'; // se houver
        $client_id = 'laravel_subscriber_' . uniqid();

        $mqtt = new phpMQTT($server, $port, $client_id);

        if (!$mqtt->connect(true, NULL, $username, $password)) {
            $this->error("Erro ao conectar ao broker MQTT");
            return 1;
        }

        $this->info("Conectado ao MQTT. Escutando...");

        $topics['topictemp/freezer'] = [
            'qos' => 0,
            'function' => function ($topic, $message) {
                Log::info("Recebido no t�pico {$topic}: {$message}");
                error_log($message);
                // Exemplo: dados JSON vindos do MQTT
                $data = json_decode($message, true);
                
                // Salvar no banco
                Leitura::create([
                    'freezer_id' => $data['codigo'],
                    'temperatura' => $data['temperatura'] ?? null,
                    'umidade' => $data['umidade'] ?? null,
                ]);

                $this->alertTelegram($data);
            }
        ];

        $mqtt->subscribe($topics, 0);

        while ($mqtt->proc()) {
        }

        $mqtt->close();
        return 0;
    }

    function alertTelegram($data)
    {
        $freezer = Freezer::where('id', $data['codigo'])->first();
        $mensagens = "O freezer de ({$freezer['numero']})";
        $response = false;

        if ($data['temperatura'] < $freezer['temp_min']) {
            $mensagens .= "\n Atenção: a temperatura caiu abaixo do valor mínimo de segurança ({$freezer['temp_min']}°C). A última medição foi de {$data['temperatura']}°C.\n";
            $response = true;
        }
        
        if ($data['temperatura'] > $freezer['temp_max']) {
            $mensagens .= "\n Atenção: a temperatura ultrapassou o valor máximo permitido ({$freezer['temp_max']}°C). A última medição foi de {$data['temperatura']}°C.\n";
            $response = true;
        }
        
        if ($data['umidade'] < $freezer['umid_min']) {
            $mensagens .= "\n Alerta: a umidade está abaixo do valor mínimo permitido ({$freezer['umid_min']}%). Última leitura registrada: {$data['umidade']}%.\n";
            $response = true;
        }
        
        if ($data['umidade'] > $freezer['umid_max']) {
            $mensagens .= "\n Alerta: a umidade ultrapassou o valor máximo permitido ({$freezer['umid_max']}%). Última leitura registrada: {$data['umidade']}%.\n";
            $response = true;
        }

        if($response){
           // $mensagens = mb_convert_encoding($mensagens, 'UTF-8', 'UTF-8');
            app(TelegramService::class)->sendMessage($freezer['codigo_telegram'], $mensagens);
        }
    }
}
