<?php

namespace emanuele0204\PlayerSize;

use pocketmine\plugin\PluginBase;
use pocketmine\command\{
    Command, CommandSender
};
use pocketmine\{
    event\Listener, event\player\PlayerRespawnEvent, Server, Player
};

class PlayerSize extends PluginBase implements Listener {

    /** @var int[] $playerSizes */
    public $playerSizes = array();

    public function onEnable() {
        //$this->getLogger()->info("§8» §ePlayerSize attivo"); odiosi messaggi che spammano sulla console
        $this->getServer()->getCommandMap()->register("size", new SizeCommand($this));
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function respawn(PlayerRespawnEvent $event) {
        $player = $event->getPlayer();
        $name = $player->getName();
        if (isset($this->getPlayerSizes()[$name]))
            $player->setDataProperty($player::DATA_SCALE, $player::DATA_TYPE_FLOAT, $this->getPlayerSizes()[$name]);
    }

    public function setSize(float $size, Player $player) {
        $player->setDataProperty($player::DATA_SCALE, $player::DATA_TYPE_FLOAT, $size);
        if ($size != 1)
            $this->getPlayerSizes()[$player->getName()] = $size;
    }

    /**
     * @return \int[]
     */
    public function getPlayerSizes(): array {
        return $this->playerSizes;
    }
}