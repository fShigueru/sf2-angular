<?php
/**
 * Created by PhpStorm.
 * User: Akatcham
 * Date: 01/08/2015
 * Time: 19:19
 */

namespace Admin\CommonBundle\Service\Logger;

use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class LoggerService implements ILoggerService
{

    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function log($message)
    {
        $this->logger->addInfo($message);
    }

    public function error($message)
    {
        $this->logger->addError($message);
    }
}