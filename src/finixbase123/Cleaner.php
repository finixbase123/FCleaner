<?php

namespace finixbase123;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\entity\ItemSpawnEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\Config;
use pocketmine\entity\object\ItemEntity;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Server;
use pocketmine\Player;
use finixbase123\CleanerCommand;

class Cleaner extends PluginBase implements Listener {

  public $database;
  public $data;

  function onEnable() {
    Server::getInstance()->getPluginManager()->registerEvents($this, $this);
    @mkdir($this->getDataFolder());
    $this->database = new Config($this->getDataFolder() . 'Data.yml', Config::YAML, ['time' => 60]);
    $this->db = $this->database->getAll();
    $this->getServer()->getCommandMap()->register('cleaner', new CleanerCommand());
  }

  function onDisable() {
    $this->database->setAll($this->db);
    $this->database->save();
  }
  
  function spawn(ItemSpawnEvent $event) {
    $entity = $event->getEntity();
    if($entity instanceof ItemEntity) {
        static $itemLifeProperty = null;
        if($itemLifeProperty === null) {
            $itemReflection = new \ReflectionClass(ItemEntity::class);
            $itemLifeProperty = $itemReflection->getProperty("age");
            $itemLifeProperty->setAccessible(true);
        }
        $before = $itemLifeProperty->getValue($entity);
        $itemLifeProperty->setValue($entity, min(0x7fff, max(0, $before + 6000 - $this->db['time'] * 20)));
        //var_dump($before);
    }
  }
}
