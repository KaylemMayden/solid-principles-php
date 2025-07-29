<?php

/**
 * OPEN-CLOSED PRINCIPLE - BEFORE
 *
 * This code violates OCP because it requires modification
 * every time a new shape is added.
 */

class Square
{
    public $width;
    public $height;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }
}

class Circle
{
    public $radius;

    public function __construct($radius)
    {
        $this->radius = $radius;
    }
}

/**
 * This breaks the open-closed principle because you are modifying existing code
 * every time you add support for a new shape.
 *
 * For example, if your boss later requests a Triangle class,
 * you would have to modify this method again.
 */
class AreaCalculator
{
    public function calculate(array $shapes)
    {
        $area = 0;

        foreach ($shapes as $shape) {
            if ($shape instanceof Square) {
                $area += $shape->width * $shape->height;
            } elseif ($shape instanceof Circle) {
                $area += $shape->radius * $shape->radius * pi();
            }
            // Every new shape requires adding another elseif condition here!
        }

        return $area;
    }
}

/**
 * Problems with this approach:
 *
 * 1. Adding new shapes requires modifying AreaCalculator
 * 2. Violates Open-Closed Principle (not open for extension, requires modification)
 * 3. Growing chain of if/else statements
 * 4. AreaCalculator needs to know about every shape type
 * 5. Risk of breaking existing functionality when adding new shapes
 */
