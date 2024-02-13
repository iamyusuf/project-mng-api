<?php

function fiber_to_coroutine(\Fiber $fiber): \Generator
{
    $index = -1; // Note: Pre-increment is faster than post-increment
    $value = null;

    // allow an already running fiber
    if (!$fiber->isStarted()) {
        $value = yield ++$index => $fiber->start();
    }

    // A Fiber without suspends should return the result immediately.
    if (!$fiber->isTerminated()) {
        while (true) {
            $value = $fiber->resume($value);

            // The last call to "resume()" moves the execution of the
            // Fiber to the "return" stmt.
            //
            // So the "yield" is not needed. Skip this step and return
            // the result.

            if ($fiber->isTerminated()) {
                break;
            }

            $value = yield ++$index => $value;
        }
    }

    return $fiber->getReturn();
}
