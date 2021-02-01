<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Database\Context;
use Nette\SmartObject;

/**
 * Základní model pro všechny ostatní databázové modely aplikace.
 * Poskytuje přístup k práci s databází.
 * @package App\Model
 */
class DatabaseManager
{
    use SmartObject;

    /** @var Context Služba pro práci s databází. */
    protected $database;

    /**
     * Konstruktor s injektovanou službou pro práci s databází.
     * @param Context $database Automaticky injektovaná Nette služba pro práci s databází
     */
    public function __construct(Context $database)
    {
        $this->database = $database;
    }
}