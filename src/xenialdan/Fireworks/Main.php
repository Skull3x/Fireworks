<?php

/*
 * Fireworks
 * A plugin by thebigsmileXD
 * http://github.com/thebigsmileXD/Fireworks
 * Fireworks using fake items and particles
 */
namespace xenialdan\Fireworks;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\entity\Entity;
use pocketmine\network\protocol\AddItemEntityPacket;
use pocketmine\item\Item;
use pocketmine\level\particle\Particle;
use pocketmine\level\Position;

class Main extends PluginBase implements Listener{
	public $i = 0;

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		// $this->getServer()->getScheduler()->scheduleRepeatingTask(new SendTask($this), 20);
	}

	public function onInteract(PlayerInteractEvent $event){
		$player = $event->getPlayer();
		if($player->getInventory()->getItemInHand()->getId() === Item::STICK){
			$launchorigin = $event->getBlock()->getSide($event->getFace())->add(0.5, 0.5, 0.5);
			
			$pk = new AddItemEntityPacket();
			$eid = $pk->eid = Entity::$entityCount++;
			$pk->x = $launchorigin->x;
			$pk->y = $launchorigin->y;
			$pk->z = $launchorigin->z;
			$pk->speedX = 0;
			$pk->speedY = 1.5;
			$pk->speedZ = 0;
			$pk->item = Item::get(Item::LIT_REDSTONE_TORCH);
			$player->getLevel()->addChunkPacket($player->getX() >> 4, $player->getZ() >> 4, $pk);
			$this->getServer()->getScheduler()->scheduleDelayedTask(new AddParticleTask($this, $launchorigin->add(0, 20), $eid), 20);
		}
	}
	
	public function addExplodeParticle(Position $pos, Particle $particle){
		$pos->getLevel()->addParticle($particle);
	}
}