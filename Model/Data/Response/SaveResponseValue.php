<?php

/**
 * SaveResponseValue
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Model\Data\Response;

use Opengento\BetterBo\Api\Data\SaveResponseValueInterface;

class SaveResponseValue implements SaveResponseValueInterface
{
    protected array $success = [];

    protected array $error = [];

    /**
     * @return string[]
     */
    public function getSuccess(): array
    {
        return $this->success;
    }

    /**
     * @param string[] $success
     * @return void
     */
    public function setSuccess(array $success): void
    {
        $this->success = $success;
    }

    /**
     * @return string[]
     */
    public function getError(): array
    {
        return $this->error;
    }

    /**
     * @param string[] $error
     * @return void
     */
    public function setError(array $error): void
    {
        $this->error = $error;
    }
}
