<?php declare(strict_types=1);

namespace App\Http\Controller;

use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;

/**
 * Class TestRuntimeController
 * @package App\Http\Controller
 *
 * @controller(prefix="test")
 */
class TestRuntimeController
{
    /**
     *
     * @RequestMapping(route="index")
     *
     * @return string
     */
    public function index() {
        return "test/index";
    }

    /**
     *
     * @RequestMapping(route="factorial/{number}")
     *
     * @param int $number
     * @return array
     */
    public function factorial(int $number): array
    {
        $factorial = function ($arg) use (&$factorial) {
            if (1 == $arg) {
                return $arg;
            }

            return $arg * $factorial($arg -1);
        };

        return [$factorial($number)];
    }
}
