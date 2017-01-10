<?php

namespace emanuele0204\PlayerSize;

use pocketmine\command\{
    Command, CommandSender, PluginIdentifiableCommand
};
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class SizeCommand extends Command implements PluginIdentifiableCommand {

    private $plugin;

    public function __construct($plugin) {
        $this->plugin = $plugin;
        $this->setPermission("playersize.command.size");
        parent::__construct("size", "Ti permette di cambiare la tua grandezza", "/size 1-20|reset|help", ["sz"]);
    }

    public function execute(CommandSender $sender, $commandLabel, array $args) {
        if ($sender instanceof Player) {
            if ($this->testPermission($sender)) {
                if (isset($args[0])) {
                    if (is_numeric($args[0])) {
                        if ($args[0] >= 1 && $args[0] <= 20) {
                            $this->getPlugin()->setSize((float)$args[0], $sender);
                            $sender->sendMessage("§8» §fSize cambiata in §e" . $args[0] . " §f!");
                        } else {
                            $sender->sendMessage("La grandezza deve essere un numero tra 1 e 20");
                        }
                    } elseif ($args[0] == "reset") {
                        unset($this->getPlugin()->getPlayerSizes()[$sender->getName()]);
                        $this->getPlugin()->setSize(1, $sender);
                        $sender->sendMessage("§8» §aSize ritornata normale!");
                    } else {
                        $this->showHelp($sender);
                    }
                } else {
                    $this->showHelp($sender);
                }
            }
        } else {
            $sender->sendMessage(TextFormat::RED . "Puoi usare questo comando solo in-game");
        }
    }


    public function showHelp(Player $player){
        $player->sendMessage("§8» §c/size §a1-20 §7=> §fImposta una size");
        $player->sendMessage("§8» §c/size §areset §7=> §fFai tornare normale la tua size");
        $player->sendMessage("§8» §c/size §ahelp §7=> §fVisualizza questo menù");
    }
    /**
     * @return PlayerSize
     */
    public function getPlugin() {
        return $this->plugin;
    }
}