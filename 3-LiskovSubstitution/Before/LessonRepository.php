<?php

/**
 * LISKOV SUBSTITUTION PRINCIPLE - BEFORE
 *
 * This code violates LSP because implementations return different types,
 * making them not truly substitutable.
 */

interface LessonRepositoryInterface
{
    public function getAll();
}

/**
 * File-based repository implementation
 */
class FileLessonRepository implements LessonRepositoryInterface
{
    public function getAll()
    {
        // Return an array of lessons
        return [
            ['id' => 1, 'title' => 'Introduction to PHP', 'duration' => 30],
            ['id' => 2, 'title' => 'Object-Oriented Programming', 'duration' => 45],
            ['id' => 3, 'title' => 'SOLID Principles', 'duration' => 60],
        ];
    }
}

/**
 * Database-based repository implementation using a Collection-like object
 */
class EloquentLessonRepository implements LessonRepositoryInterface
{
    public function getAll()
    {
        // Return a collection of lessons (simulating Laravel's Eloquent)
        return new LessonCollection([
            ['id' => 1, 'title' => 'Introduction to PHP', 'duration' => 30],
            ['id' => 2, 'title' => 'Object-Oriented Programming', 'duration' => 45],
            ['id' => 3, 'title' => 'SOLID Principles', 'duration' => 60],
        ]);
    }
}

/**
 * Simple collection class to simulate Laravel's Collection
 */
class LessonCollection
{
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function toArray()
    {
        return $this->items;
    }

    public function count()
    {
        return count($this->items);
    }
}

/**
 * Consumer code that violates LSP
 */
function displayLessons(LessonRepositoryInterface $repo)
{
    $lessons = $repo->getAll();

    // If $lessons is sometimes an array and sometimes a collection,
    // you might be forced to do type checks:
    if ($lessons instanceof LessonCollection) {
        // Handle collection
        echo "Found " . $lessons->count() . " lessons:\n";
        foreach ($lessons->toArray() as $lesson) {
            echo "- {$lesson['title']} ({$lesson['duration']} min)\n";
        }
    } elseif (is_array($lessons)) {
        // Handle array
        echo "Found " . count($lessons) . " lessons:\n";
        foreach ($lessons as $lesson) {
            echo "- {$lesson['title']} ({$lesson['duration']} min)\n";
        }
    }

    // This type checking is a sign that you are breaking both
    // the Open-Closed Principle and the Liskov Substitution Principle.
}

/**
 * Problems with this approach:
 *
 * 1. Implementations return different types (array vs collection)
 * 2. Consumer code needs to check types
 * 3. Not truly substitutable - behavior changes based on implementation
 * 4. Violates Liskov Substitution Principle
 * 5. Breaks Open-Closed Principle (consumer needs modification for new return types)
 */
