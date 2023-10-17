<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\SettingType;

interface Setting
{
    public function __construct(SettingType $settingType);
    public function setSettingName(string $name = 'duplicateWindow') : void;
    public function setSettingValue(string $value = '60') : void;
    public function getSetting() : SettingType;
}
