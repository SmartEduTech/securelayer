<?php

namespace Smartedutech\Securelayer\Watchdog;

use Smartedutech\Securelayer\Log\AgentLog;

class WatchDog
{
    public function run(string $strategywatchdog)
    {
        $this->scanActivity();
        $this->scanClient();
        $this->analyseAlert($strategywatchdog);
    }

    public function analyseAlert(string $strategywatchdog)
    {
        $activity = json_decode(ActivityScan::scanAllInfo(), true);
        $client = json_decode(ClientScan::getClient(), true);

        if ($client && $client['REMOTE_ADDR'] == '127.0.0.1') {
            $this->handleAlert('Local IP detected');
        }

        if ($activity && $activity['status'] === 404 && $client && $client['REMOTE_ADDR'] === '127.0.0.1') {
            $this->handleAlert('Alerte de la stratégie 1 : activité et client suspects');
        } elseif ($client && !empty($client['GEOLOCATION']['latitude']) && !empty($client['GEOLOCATION']['longitude'])) {
            $this->handleAlert('Alerte de la stratégie 2 : géolocalisation disponible');
        } else {
            $this->handleNoAlert();
        }

        if ($client && empty($client['EMAIL'])) {
            $this->handleAlert('Adresse email introuvable');
        }

        if ($client && isset($client['HTTP_AUTHORIZATION']) && $client['HTTP_AUTHORIZATION']) {
            $this->handleAlert('HTTP Authorisation detectée');
        }

        if ($activity && empty($client['HTTP_REFERER'])) {
            $this->handleAlert('Aucune page détectée');
        }

        if ($activity && $activity['status'] != 200) {
            $this->handleAlert('Non-200 URI status détectée');
        }

        if ($activity && $activity['REQUEST_PARAMS'] !== 'GET') {
            $this->handleAlert('Méthode de requête non GET');
        }
    }

    private function handleAlert(string $message)
    {
        // Gérer l'alerte, par exemple, enregistrer dans un fichier de log ou envoyer une notification
        echo $message;
        AgentLog::LogerMessage($message);

    }

    private function handleNoAlert()
    {
        // Gérer le cas où aucune alerte n'a été détectée
        // Par exemple, ne rien faire ou enregistrer un message indiquant l'absence d'alerte
        echo 'Aucune alerte détectée';
        AgentLog::LogerMessage('Aucune alerte détectée');
    }

    public function scanClient()
    {
        $client = json_decode(ClientScan::getClient(), true);
        echo json_encode($client);
        AgentLog::LogerMessage(json_encode($client));
    }

    public function scanActivity()
    {
        echo ActivityScan::scanAllInfo();
        AgentLog::LogerMessage(ActivityScan::scanAllInfo());
    }
}
