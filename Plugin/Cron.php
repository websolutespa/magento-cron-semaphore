<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\CronSemaphore\Plugin;

use Exception;
use Magento\Framework\Exception\LocalizedException;
use Websolute\CronSemaphore\Model\CronSempahoreManager;

class Cron
{
    /**
     * @var CronSempahoreManager
     */
    private $cronSempahoreManager;

    /**
     * @param CronSempahoreManager $cronSempahoreManager
     */
    public function __construct(
        CronSempahoreManager $cronSempahoreManager
    ) {
        $this->cronSempahoreManager = $cronSempahoreManager;
    }

    /**
     * @param \Magento\Framework\App\Cron $subject
     * @param callable $proceed
     * @return mixed
     * @throws Exception
     */
    public function aroundLaunch(\Magento\Framework\App\Cron $subject, callable $proceed)
    {
        if ($this->cronSempahoreManager->isSupended()) {
            throw new LocalizedException(__('Cron suspended by CronSemaphore command'));
        }

        return $proceed();
    }
}
