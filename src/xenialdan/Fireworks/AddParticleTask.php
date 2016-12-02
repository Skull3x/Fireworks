<?php

namespace xenialdan\Fireworks;

use pocketmine\scheduler\PluginTask;
use pocketmine\plugin\Plugin;
use pocketmine\level\Position;
use pocketmine\level\particle\HugeExplodeParticle;
use pocketmine\network\protocol\RemoveEntityPacket;

class AddParticleTask extends PluginTask{

	public function __construct(Plugin $owner, Position $pos, $eid){
		parent::__construct($owner);
		$this->plugin = $owner;
		$this->pos = $pos;
		$this->eid = $eid;
	}

	public function onRun($currentTick){
		$this->getOwner()->addExplodeParticle($this->pos, new HugeExplodeParticle($this->pos));
		
		$pk = new RemoveEntityPacket();
		$pk->eid = $this->eid;
		$this->pos->getLevel()->addChunkPacket($this->pos->getX() >> 4, $this->pos->getZ() >> 4, $pk);
	}

	public function cancel(){
		$this->getHandler()->cancel();
	}
}
?>