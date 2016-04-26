<?php

namespace EVFramework\Translation;

class InstanceCreator
{
    public static function factory()
    {
        return \Translation_Manager::getInstance();
    }
}
