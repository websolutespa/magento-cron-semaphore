<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\CronSemaphore\Model;

use DateInterval;
use DateTime;
use Exception;
use Magento\Framework\Flag;
use Magento\Framework\Flag\FlagResource;
use Magento\Framework\FlagFactory;
use Websolute\CronSemaphore\Api\CronSempahoreManagerInterface;

class CronSempahoreManager implements CronSempahoreManagerInterface
{
    /**
     * @var FlagResource
     */
    private $flagResource;

    /**
     * @var FlagFactory
     */
    private $flagFactory;

    /**
     * @param FlagResource $flagResource
     * @param FlagFactory $flagFactory
     */
    public function __construct(
        FlagResource $flagResource,
        FlagFactory $flagFactory
    ) {
        $this->flagResource = $flagResource;
        $this->flagFactory = $flagFactory;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function suspend(int $forSeconds = CronSempahoreManagerInterface::TIMEOUT_EXPIRE)
    {
        $expire = new DateTime();
        $expire->add(new DateInterval('PT' . $forSeconds . 'S'));
        $sempaphore = $this->getFlagObject();
        $sempaphore->setFlagData($expire);
        $this->flagResource->save($sempaphore);
    }

    /**
     * @return Flag
     */
    private function getFlagObject(): Flag
    {
        $flag = $this->flagFactory->create(
            [
                'data' => [
                    'flag_code' => CronSempahoreManagerInterface::CONFIG_KEY
                ]
            ]
        );
        $this->flagResource->load($flag, CronSempahoreManagerInterface::CONFIG_KEY, 'flag_code');
        return $flag;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function resume()
    {
        $sempaphore = $this->getFlagObject();
        if ($sempaphore) {
            $this->flagResource->delete($sempaphore);
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function isSupended(): bool
    {
        $sempaphore = $this->getFlagObject();
        $flagData = $sempaphore->getFlagData();

        if ($flagData === null) {
            return false;
        }

        $now = new DateTime();
        $expire = new DateTime($flagData['date']);

        return $now < $expire;
    }
}
