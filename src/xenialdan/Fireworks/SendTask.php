<?php

namespace xenialdan\Fireworks;

use pocketmine\scheduler\PluginTask;
use pocketmine\plugin\Plugin;
use pocketmine\Player;

class SendTask extends PluginTask{

	public function __construct(Plugin $owner){
		parent::__construct($owner);
		$this->plugin = $owner;
	}

	public function onRun($currentTick){
		$this->getOwner()->SendAttributes();
	}

	public function cancel(){
		$this->getHandler()->cancel();
	}
}
?>