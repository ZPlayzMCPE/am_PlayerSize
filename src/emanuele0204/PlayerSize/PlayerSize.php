<?php

namespace emanuele0204\PlayerSize;

use pocketmine\plugin\PluginBase;
use pocketmine\command\{Command, CommandSender};
use pocketmine\entity\Entity;
use pocketmine\{Server, Player};

class PlayerSize extends PluginBase{
    
    public $b = array();
    public function onEnable(){
        $this->getLogger()->info("§8» §ePlayerSize active, loaded.");
        $this->getServer()->getCommandMap()->register("size", new pSize($this));
    }
    
    public function respawn(PlayerRespawnEvent $e){
        $o = $e->getPlayer();
        if(!empty($this->b[$o->getName()])){
            $nomep = $this->b[$o->getName()];
            $o->setDataProperty(Entity::DATA_SCALE, Entity::DATA_TYPE_FLOAT, $nomep);
        }
    }
}

class pSize extends Command{
    
    private $p;
    public function __construct($plugin){
        $this->p = $plugin;
        parent::__construct("size", "§aPlayerSize by §bVMPE development Team\n§d§l>>>>> §aPlayerSize §Help Page §d§l<<<<<\n§r&a/size <0.5-5> - §bChange your player size.\n§a/size reset - §bResets the size, and is all back to normal.");
    }
    
    public function execute(CommandSender $g, string $label, array $args){
        if($g->hasPermission("playersize.size")){
            if(isset($args[0])){
                if(is_numeric($args[0])){
                  if ($args[0] >= 0.5 && $args[0] <= 5) {
                    $this->p->b[$g->getName()] = $args[0];
                    $g->setDataProperty(Entity::DATA_SCALE, Entity::DATA_TYPE_FLOAT, $args[0]);
                    $g->sendMessage("§8» §aSize changed in §2".$args[0]." §aSuccesfully! §bCheck you out! :)");
                }elseif($args[0] == "reset"){
                    if(!empty($this->p->b[$g->getName()])){
                        unset($this->p->b[$g->getName()]);
                        $g->setDataProperty(Entity::DATA_SCALE, Entity::DATA_TYPE_FLOAT, 1.0);
                        $g->sendMessage("§8» §aNormal return size!");
                    }else{
                        $g->sendMessage("§8» §cUse §f/size §ereset §cor §f/size §e<size>");
                    }
                }else{
                    $g->sendMessage("§8» §cI'm sorry, but the size must be between §40.5 §cnd §45. (0.5 = Small) (1 = Normal) (5 = Big)");
               }
            }
         }
      }
   }
}
