<?php

/**
 * GetResponseData
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Model\Data\Response;

use Opengento\BetterBo\Api\Data\GetResponseDataInterface;

class GetResponseData implements GetResponseDataInterface
{
    /**
     * @var \Opengento\BetterBo\Api\Data\GetResponseConfigInterface
     */
    protected \Opengento\BetterBo\Api\Data\GetResponseConfigInterface $config;

    /**
     * @var \Opengento\BetterBo\Api\Data\GetResponseValuesInterface[]
     */
    protected array $values = [];

    /**
     * @return \Opengento\BetterBo\Api\Data\GetResponseConfigInterface
     */
    public function getConfig(): \Opengento\BetterBo\Api\Data\GetResponseConfigInterface
    {
        return $this->config;
    }

    /**
     * @param \Opengento\BetterBo\Api\Data\GetResponseConfigInterface $config
     * @return void
     */
    public function setConfig(\Opengento\BetterBo\Api\Data\GetResponseConfigInterface $config): void
    {
        $this->config = $config;
    }

    /**
     * @return \Opengento\BetterBo\Api\Data\GetResponseValuesInterface[]
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param \Opengento\BetterBo\Api\Data\GetResponseValuesInterface[] $values
     * @return void
     */
    public function setValues(array $values): void
    {
        $this->values = $values;
    }
}
