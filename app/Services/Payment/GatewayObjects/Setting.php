<?php


namespace App\Services\Payment\GatewayObjects;


use net\authorize\api\contract\v1\SettingType;

class Setting implements \App\Contracts\Payment\GatewayObjects\Setting
{

    protected SettingType $settingType;

    public function __construct(SettingType $settingType)
    {
        $this->settingType = $settingType;
    }

    public function setSettingName(string $name = 'duplicateWindow'): void
    {
        $this->settingType->setSettingName($name);
    }

    public function setSettingValue(string $value = '60'): void
    {
        $this->settingType->setSettingValue($value);
    }

    public function getSetting(): SettingType
    {
        return $this->settingType;
    }
}
