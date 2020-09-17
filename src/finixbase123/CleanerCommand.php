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
    parent::__construct('클리너', '클리너에 관한 명령어입니다.', '/클리너', ['cleaner']);
  }

  public function execute(CommandSender $sender, string $commandLabel, array $args)
  {
    $name = strtolower($sender->getName());
    if(!$sender->isOp()) return false;
    if(!isset($args[0]) or !isset($args[1])) {
      $sender->sendMessage(self::PREFIX . '/클리너 시간설정 [초 : int]');
      $sender->sendMessage(self::PREFIX . '/cleaner set [second : int]');
      return false;
    }
    if($args[0] == '시간설정' or $args[0] =='set') {
      Cleaner::getInstance()->db['time'] = $args[1];
      $sender->sendMessage(self::PREFIX . '성공적으로 아이템 클리너 시간을 ' . $args[1] . '로 설정하였습니다.');
      return true;
    }
}
}

?>
