<?php

namespace _PhpScoper5f3e4b2e25c2b\GuzzleHttp\Promise;

interface TaskQueueInterface
{
    /**
     * Returns true if the queue is empty.
     *
     * @return bool
     */
    public function isEmpty();
    /**
     * Adds a task to the queue that will be executed the next time run is
     * called.
     *
     * @param callable $task
     */
    public function add(callable $task);
    /**
     * Execute all of the pending task in the queue.
     */
    public function run();
}
