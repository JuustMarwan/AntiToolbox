<?php

declare(strict_types = 1);

namespace Zinkil\AntiToolbox;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use Zinkil\AntiToolbox\Listeners\EventListener;

class Loader extends PluginBase{

	private static $instance;

    public function onEnable() : void{
		self::$instance = $this;
		$this->setListeners();
	}

    public static function getInstance() : Loader{
		return self::$instance;
	}

    public function setListeners(){
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
	}
}