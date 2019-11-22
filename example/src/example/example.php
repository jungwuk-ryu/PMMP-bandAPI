<?php

namespace example;

/**
* 테스트 되지 않음
* 플레이어 서버 퇴장시 밴드에 글로 알림
**/

use pocketmine\utils\Config;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\player\PlayerQuitEvent;

class example extends PluginBase implements Listener
{
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    public function onQuit(PlayerQuitEvent $ev)
    {
        $this->getServer()->getPluginManager()->getPlugin("bandAPI_hc")->writePost($ev->getPlayer()->getName() . "님이 서버에서 퇴장하셨습니다.", "여기에 band_key의 값을 입력하세요.", false);
    }
}
