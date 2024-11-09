<?php

/**
 * SaveResponse
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Opengento\BetterBo\Model\Data\Response;

use Opengento\BetterBo\Api\Data\SaveResponseInterface;

class SaveResponse implements SaveResponseInterface
{
    /**
     * @var string
     */
    protected string $type;

    /**
     * @var string
     */
    protected string $message;

    /**
     * @var \Opengento\BetterBo\Api\Data\SaveResponseValueInterface|null
     */
    protected ?\Opengento\BetterBo\Api\Data\SaveResponseValueInterface $data;

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
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return void
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return \Opengento\BetterBo\Api\Data\SaveResponseValueInterface|null
     */
    public function getData(): ?\Opengento\BetterBo\Api\Data\SaveResponseValueInterface
    {
        return $this->data;
    }

    /**
     * @param \Opengento\BetterBo\Api\Data\SaveResponseValueInterface $data
     * @return void
     */
    public function setData(\Opengento\BetterBo\Api\Data\SaveResponseValueInterface $data): void
    {
        $this->data = $data;
    }
}
