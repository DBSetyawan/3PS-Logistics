<?php

namespace warehouse\Http\Controllers\TestGenerator;

class SingletonTest
{
    protected static $_instance;

    /**
     * @method allowed all instruction
     */
    private function __construct(){}

    /**
     * @method class to clone
     */
    private function __clone(){}

    public static function getInstance() {

        if (null === static::$_instance) {
            static::$_instance = new static();
        }

        return static::$_instance;
    }

    public function test2(){
        return 12;
    }
}


class ExtendSingleton extends SingletonTest
{
    public function test2() {
        return 13;
    }
}


$b = ExtendSingleton::getInstance();
    echo $b->test2();

$a = SingletonTest::getInstance();
    echo $a->test2();

exit;