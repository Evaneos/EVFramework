<?php

namespace EVFramework\Generator\Configuration;

interface Definition
{
    const OBJECT_MAIN_NAME  = 'mainName';
    const OBJECT_NAME       = 'vo';
    const OBJECT_REST_NAME  = 'rest';
    const OBJECT_TABLE_NAME = 'table';

    const PARAM_CFG_DEF_TPL = 'crud.configuration.definition_name';
    const PARAM_PACKAGES    = 'crud.packages';
    const PARAM_NAMESPACE   = 'crud.namespace';
}
