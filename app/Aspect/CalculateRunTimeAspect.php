<?php


namespace App\Aspect;

use App\Http\Controller\TestRuntimeController;
use Swoft\Aop\Annotation\Mapping\After;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\Around;
use Swoft\Aop\Annotation\Mapping\Before;
use Swoft\Aop\Annotation\Mapping\PointBean;
use Swoft\Aop\Point\JoinPoint;
use Swoft\Aop\Point\ProceedingJoinPoint;

/**
 * Class CalculateRunTimeAspect
 * @package App\Aspect
 *
 * @Aspect(order=1)
 *
 * @PointBean(include={TestRunTimeController::class})
 */
class CalculateRunTimeAspect
{
    /** @var float 开始执行时间 */
    private $time_begin;

    /**
     * @Before()
     */
    public function beforeAdvice() {
        $this->time_begin = microtime(true);
    }

    /**
     * @After()
     *
     * @param JoinPoint $joinPoint
     */
    public function afterAdvice(JoinPoint $joinPoint) {
        $timeFinish = microtime(true);
        $method = $joinPoint->getMethod();
        $runtime = round(($timeFinish - $this->time_begin)*1000,3);
        echo "{$method} 方法，after - before 本次执行时间为 {$runtime}\n";
    }

    /**
     * @Around
     *
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws \Throwable
     */
    public function aroundAdvice(ProceedingJoinPoint $proceedingJoinPoint) {
        $start = microtime(true);
        $method = $proceedingJoinPoint->getMethod();
        $ret = $proceedingJoinPoint->proceed();
        $finish = microtime(true);
        $runtime = round( ($finish - $start) , 3);
        echo "{$method} 方法, around 本次执行时间: {$runtime}\n";
        return $ret;
    }
}
