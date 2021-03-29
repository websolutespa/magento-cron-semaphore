# Magento 2 Module: CronSemaphore

## Purpose

When you put the semaphore in red status, all the cron jobs are suspended until you programmatically call the resume
method or after the timeout limit.

## How to use

Just inject the following manager:

    \Websolute\CronSemaphore\Api\CronSempahoreManagerInterface $cronSempahoreManager

The use the `suspend(int $forSeconds = 300)` command to put the semaphore in red status:

    $this->cronSempahoreManager->suspend();
    $this->cronSempahoreManager->suspend(600); // Pass an integer that represents the timeout at 600 seconds

The use the `resume()` command to put the semaphore in green status:

    $this->cronSempahoreManager->resume();
