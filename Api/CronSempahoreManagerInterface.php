<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\CronSemaphore\Api;

use Magento\Framework\Exception\AlreadyExistsException;

interface CronSempahoreManagerInterface
{
    /** @var string */
    const CONFIG_KEY = 'cron_semaphore';

    /** @var int */
    const TIMEOUT_EXPIRE = 360;

    /**
     * @param int $forSeconds
     * @throws AlreadyExistsException
     */
    public function suspend(int $forSeconds = self::TIMEOUT_EXPIRE);

    /**
     * @return null
     */
    public function resume();

    /**
     * @return bool
     */
    public function isSupended(): bool;
}
