<?php

/**
 * GetResponseConfig
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Model\Data\Response;


use Opengento\BetterBo\Api\Data\GetResponseConfigInterface;

class GetResponseConfig implements GetResponseConfigInterface
{
    /**
     * @var string
     */
    protected string $type;

    /**
     * @var string
     */
    protected string $frontendLabel;

    /**
     * @var \Opengento\BetterBo\Api\Data\GetResponseConfigOptionsInterface
     */
    protected array $options;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return void
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getFrontendLabel(): string
    {
        return $this->frontendLabel;
    }

    /**
     * @param string $frontendLabel
     * @return void
     */
    public function setFrontendLabel(string $frontendLabel): void
    {
        $this->frontendLabel = $frontendLabel;
    }

    /**
     * @return \Opengento\BetterBo\Api\Data\GetResponseConfigOptionsInterface[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param \Opengento\BetterBo\Api\Data\GetResponseConfigOptionsInterface[] $options
     * @return void
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
}
