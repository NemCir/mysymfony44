<?php

namespace App\Services;

use Doctrine\ORM\Query\Expr\Func;
use Psr\Log\LoggerInterface;

class GiftsService {
    public $gifts = ['flowers', 'car', 'money'];
    
    public function __construct(LoggerInterface $logger)
    {
        $logger->info('Gifts were randomized');
        shuffle($this->gifts);
    }
}