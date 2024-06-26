<?php

declare(strict_types=1);

namespace App\App\Model;

class Types
{
    const STATUS = array('NEW' => 'new', 'ACT' => 'active', 'END' => 'closed');
    const contractType = array('partner-sale' => 'partner', 'customer-sale' => 'customer');
    
    
    /**
     * @param string $key
     * @return string
     */
    public function getStatus(string $key) : string
    {
        return  self::STATUS[$key];
    }
}