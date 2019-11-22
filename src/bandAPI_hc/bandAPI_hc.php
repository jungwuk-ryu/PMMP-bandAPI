<?php
namespace bandAPI_hc;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;

class bandAPI_hc extends PluginBase
{
    public $config;
    public $token;

    public function onEnable()
    {
        $this->getLogger()->info("bandAPI by Hancho");
        @mkdir($this->getDataFolder());
        $this->config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
        $this->token = $this->config->get("token", "");
        if ($this->token == "") {
            $this->config->set("token", "");
            $this->config->save();
            $this->getLogger()->info("config.yml을 수정하여 token값을 입력해주세요.");
        }
        $this->config->save();
    }

    public function writePost($content = "no content", string $band_key, bool $do_push = true, $token = "")
    {
        $this->requestPOST('https://openapi.band.us/v2.2/band/post/create', $band_key, $content, $do_push, $token);
    }

    public function getBands($token = "")
    {
        if ($token == "") {
            if ($this->token == "") {
                $this->getLogger()->info("not found token");
                return "not found token";
            }
            $token = $this->token;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://openapi.band.us/v2.1/bands?access_token=$token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $rst=json_decode(curl_exec($ch), true);
        curl_close($ch);
        var_dump($rst);
        return $rst;
    }

    public function requestPOST($init, $band_key, $content, $do_push, $token = "")
    {
        if ($token == "") {
            if ($this->token == "") {
                $this->getLogger()->info("not found token");
                return "not found token";
            }
            $token = $this->token;
        }
        $ch = curl_init($init);
        curl_setopt($ch, CURLOPT_POST, true);
        $json= "access_token=$token&band_key=$band_key&content=".urlencode($content)."&do_push=".$do_push;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $token"]);
        $rst=json_decode(curl_exec($ch), true);
        var_dump($rst);
    }
}
