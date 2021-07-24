<?php

declare(strict_types = 1);

namespace Zinkil\AntiToolbox\Listeners;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\Server;
use pocketmine\Player;
use Zinkil\AntiToolbox\Loader;

class EventListener implements Listener{

    private $plugin;

    public function __construct(Loader $plugin){
		$this->plugin = $plugin;
	}

    public function onJoin(DataPacketReceiveEvent $event){
        $player = $event->getPlayer();
        $packet = $event->getPacket();
        if($packet instanceof LoginPacket){
			$clientId = $packet->clientId;
            $deviceOS = (int)$packet->clientData["DeviceOS"];
			$deviceId = (int)$packet->clientData['DeviceId'];
            $deviceModel = (string)$packet->clientData["DeviceModel"];

            if($deviceOS !== 1){ //1 is for Android OS
                return;
            }

			if(!$player instanceof Player){
				return;
            }

			if($player->isOp() || $player->hasPermission("antitoolbox.bypass.check")){
				return;
            }

            /**
             * Something about client id check (This method may not work), for example:
             * Original client: -8423610415471
             * Toolbox client: 0
             */

			if($clientId === 0){
                $event->setCancelled();
				$player->kick("§l§cYou Are Playing With Toolbox Client\n§r§bYou can't join this server with hack clients", false);
            }

            /**
             * Something about device model check, for example:
             * Original client: XIAOMI Note 8 Pro
             * Toolbox client: Xiaomi Note 8 Pro
             *
             * For another Example
             * Original client: SAMSUNG SM-A105F
             * Toolbox client: samsung SM-A105F
             */

            $name = explode(" ", $deviceModel);
            if(!isset($name[0])){
                return;
            }
		
            $check = $name[0];
            $check = strtoupper($check);
            if($check !== $name[0]){
                $event->setCancelled();
                $player->kick("§l§cYou Are Playing With Toolbox Client\n§r§bYou can't join this server with hack clients", false);
            }
        }
    }
}