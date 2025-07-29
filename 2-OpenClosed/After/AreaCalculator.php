<?php

/**
 * OPEN-CLOSED PRINCIPLE - AFTER
 *
 * This code adheres to OCP by being open for extension
 * but closed for modification.
 */

/**
 * Shape interface defines the contract that all shapes must follow
 */
interface Shape
{
    public function area();
}

/**
 * Square implementation of Shape
 */
class Square implements Shape
{
    public $width;
    public $height;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function area()
    {
        return $this->width * $this->height;
    }
}

/**
 * Circle implementation of Shape
 */
class Circle implements Shape
{
    public $radius;

    public function __construct($radius)
    {
        $this->radius = $radius;
    }

    public function area()
    {
        return $this->radius * $this->radius * pi();
    }
}

/**
 * Triangle implementation of Shape
 * Notice: This was added WITHOUT modifying AreaCalculator!
 */
class Triangle implements Shape
{
    public $base;
    public $height;

    public function __construct($base, $height)
    {
        $this->base = $base;
        $this->height = $height;
    }

    public function area()
    {
        return 0.5 * $this->base * $this->height;
    }
}

/**
 * Rectangle implementation of Shape
 * Another new shape added without modifying existing code!
 */
class Rectangle implements Shape
{
    public $length;
    public $width;

    public function __construct($length, $width)
    {
        $this->length = $length;
        $this->width = $width;
    }

    public function area()
    {
        return $this->length * $this->width;
    }
}

/**
 * When your boss asks for a Triangle class, you simply create it
 * implementing Shape with its own area method.
 * You never have to modify AreaCalculator again, adhering to the open-closed principle.
 */
class AreaCalculator
{
    /**
     * Now, AreaCalculator no longer needs to check for concrete classes.
     * Since all shapes implement the Shape interface, you can trust that the area method exists.
     */
    public function calculate(array $shapes)
    {
        $area = 0;

        foreach ($shapes as $shape) {
            $area += $shape->area();
        }

        return $area;
    }
}

/**
 * Benefits of this approach:
 *
 * 1. Open for extension: New shapes can be added easily
 * 2. Closed for modification: AreaCalculator never needs to change
 * 3. Polymorphism: All shapes are treated uniformly
 * 4. Maintainable: Changes to one shape don't affect others
 * 5. Testable: Each shape can be tested independently
 * 6. Follows Single Responsibility: Each shape knows how to calculate its own area
 */
