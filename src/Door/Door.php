<?php

namespace App\Door;

class Door
{
    public function __construct(
        private string $state = 'open',
    )
    {
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function close(): void
    {
        if ('open' !== $this->state) {
            throw new \LogicException(sprintf('Cannot close the door: it is %s.', $this->state));
        }

        $this->state = 'closed';
    }

    public function open(): void
    {
        if ('closed' !== $this->state) {
            throw new \LogicException(sprintf('Cannot open the door: it is %s.', $this->state));
        }

        $this->state = 'open';
    }

    public function lock(): void
    {
        if ('closed' !== $this->state) {
            throw new \LogicException(sprintf('Cannot lock the door: it is %s.', $this->state));
        }

        $this->state = 'locked';
    }

    public function unlock(): void
    {
        if ('locked' !== $this->state) {
            throw new \LogicException(sprintf('Cannot unlock the door: it is %s.', $this->state));
        }

        $this->state = 'closed';
    }
}
