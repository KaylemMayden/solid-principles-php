<?php

/**
 * INTERFACE SEGREGATION PRINCIPLE - AFTER
 *
 * This code adheres to ISP by creating specific, focused interfaces that clients only implement what they actually need.
 */

/**
 * Focused interface for work capability
 */
interface WorkableInterface
{
    public function work();
}

/**
 * Focused interface for sleep capability
 */
interface SleepableInterface
{
    public function sleep();
}

/**
 * Interface for entities that can be managed
 */
interface ManageableInterface
{
    public function beManaged();
}

/**
 * Human worker implements all relevant interfaces
 */
class HumanWorker implements WorkableInterface, SleepableInterface, ManageableInterface
{
    public function work()
    {
        echo "Human is working hard...\n";
    }

    public function sleep()
    {
        echo "Human is taking a well-deserved rest...\n";
    }

    public function beManaged()
    {
        $this->work();
        $this->sleep();
    }
}

/**
 * Robot worker only implements what it actually can do
 */
class AndroidWorker implements WorkableInterface, ManageableInterface
{
    public function work()
    {
        echo "Android is working efficiently...\n";
    }

    public function beManaged()
    {
        $this->work();
        // No sleep for robots - they don't need it!
    }
}

/**
 * This reduces coupling and improves design by depending on abstractions
 * rather than concrete implementations.
 */
class Captain
{
    /**
     * Manages any worker that can be managed
     * No assumptions about work or sleep capabilities
     */
    public function manage(ManageableInterface $worker)
    {
        $worker->beManaged();
    }

    /**
     * Specifically manages workers who can work
     */
    public function assignWork(WorkableInterface $worker)
    {
        echo "Captain: Assigning work...\n";
        $worker->work();
    }

    /**
     * Manages rest periods for workers who can sleep
     */
    public function scheduleRest(SleepableInterface $worker)
    {
        echo "Captain: Time for rest...\n";
        $worker->sleep();
    }

    /**
     * Manages a mixed team efficiently
     */
    public function manageTeam(array $workers)
    {
        foreach ($workers as $worker) {
            if ($worker instanceof ManageableInterface) {
                $this->manage($worker);
            }
        }
    }

    /**
     * Coordinates work across all capable workers
     */
    public function coordinateWork(array $workers)
    {
        foreach ($workers as $worker) {
            if ($worker instanceof WorkableInterface) {
                $this->assignWork($worker);
            }
        }
    }
}

/**
 * Benefits of this approach:
 *
 * 1. Focused interfaces: Each interface has a single, clear purpose
 * 2. No forced implementations: Classes only implement what they actually use
 * 3. Flexible composition: Classes can implement multiple interfaces as needed
 * 4. Better separation of concerns: Different capabilities are clearly separated
 * 5. Easier to extend: New worker types can be added easily
 * 6. Follows Interface Segregation Principle: Many client-specific interfaces
 * 7. Reduced coupling: Clients depend only on what they need
 */
