<?php

/**
 * INTERFACE SEGREGATION PRINCIPLE - BEFORE
 *
 * This code violates ISP by forcing clients to implement interfaces they don't use.
 */

/**
 * Fat interface that forces all workers to implement methods they might not need
 */
interface WorkerInterface
{
    public function work();
    public function sleep();
}

/**
 * Human worker - needs both work and sleep
 */
class HumanWorker implements WorkerInterface
{
    public function work()
    {
        echo "Human is working...\n";
    }

    public function sleep()
    {
        echo "Human is sleeping...\n";
    }
}

/**
 * Robot worker - only needs work, but forced to implement sleep
 * This violates ISP because robots don't sleep!
 */
class RobotWorker implements WorkerInterface
{
    public function work()
    {
        echo "Robot is working...\n";
    }

    /**
     * This is problematic - robots don't sleep!
     * We're forced to implement this method even though it doesn't make sense.
     */
    public function sleep()
    {
        // What should a robot do here?
        // This implementation is meaningless and violates ISP
        throw new Exception("Robots don't sleep!");
    }
}

/**
 * Manager class that expects all workers to work and sleep
 */
class Captain
{
    public function manage(WorkerInterface $worker)
    {
        $worker->work();
        $worker->sleep(); // This will break for robots!
    }

    public function manageTeam(array $workers)
    {
        foreach ($workers as $worker) {
            $this->manage($worker);
        }
    }
}

/**
 * Problems with this approach:
 *
 * 1. Clients forced to implement methods they don't use
 * 2. Robot workers can't properly implement sleep()
 * 3. Fat interface creates unnecessary coupling
 * 4. Violates Interface Segregation Principle
 * 5. Runtime errors when calling inappropriate methods
 * 6. Inflexible design that doesn't accommodate different worker types
 */
