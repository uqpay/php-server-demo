<?php

namespace app\models;


class Test extends Validate {
    public $merchantId;
    public $agentId;

    public function rules()
    {
        return [
            [['merchantId'], ['required']],
        ];
    }
}
