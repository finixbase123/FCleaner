<?php

namespace finixbase123;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use finixbase123\Cleaner;

class CleanerCommand extends Command {

  const PREFIX = TextFormat::GREEN . '* ' . TextFormat::WHITE;

  public function __construct() {
    parent::__construct('cleaner', 'cleaner', '/cleaner', []);
  }

  public function execute(CommandSender $sender, string $commandLabel, array $args)
  {
    if(!$sender->isOp()) return false;
    if(!isset($args[0]) or !isset($args[1])) {
      $sender->sendMessage(self::PREFIX . '/cleaner set [second : int]');
      return false;
    }
    if($args[0] =='set') {
      Cleaner::getInstance()->db['time'] = $args[1];
      $sender->sendMessage(self::PREFIX . 'Success');
      return true;
    }
}
}
