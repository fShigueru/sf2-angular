<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 20/04/2016
 * Time: 17:41
 */

namespace Admin\CommonBundle\Service\Logger;

use Symfony\Bridge\Monolog\Logger;

interface ILoggerService
{

    public function __construct(Logger $logger);

    public function log($message);

    public function error($message);

}