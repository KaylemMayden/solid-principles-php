<?php

/**
 * LISKOV SUBSTITUTION PRINCIPLE - AFTER
 *
 * This code adheres to LSP by ensuring all implementations return the same type and behave consistently.
 */

/**
 * Well-defined interface with clear return type contract
 */
interface LessonRepositoryInterface
{
    /**
     * Get all lessons
     * @return array Array of lesson data
     */
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
 * Database-based repository implementation
 */
class EloquentLessonRepository implements LessonRepositoryInterface
{
    public function getAll()
    {
        // Ensure all implementations return arrays,
        // for example by converting collections to arrays:
        $collection = new LessonCollection([
            ['id' => 1, 'title' => 'Introduction to PHP', 'duration' => 30],
            ['id' => 2, 'title' => 'Object-Oriented Programming', 'duration' => 45],
            ['id' => 3, 'title' => 'SOLID Principles', 'duration' => 60],
        ]);

        return $collection->toArray();
    }
}

/**
 * Consumer code that works with any implementation
 */
function displayLessons(LessonRepositoryInterface $repo)
{
    $lessons = $repo->getAll();

    // No need for type checking as we know both class methods return an array
    // All implementations are truly substitutable
    echo "Found " . count($lessons) . " lessons:\n";
    foreach ($lessons as $lesson) {
        echo "- {$lesson['title']} ({$lesson['duration']} min)\n";
    }
}

/**
 * Additional consumer function to demonstrate substitutability
 */
function calculateTotalDuration(LessonRepositoryInterface $repo)
{
    $lessons = $repo->getAll();
    $totalDuration = 0;

    // Works with any implementation without type checking
    foreach ($lessons as $lesson) {
        $totalDuration += $lesson['duration'];
    }

    return $totalDuration;
}

/**
 * Benefits of this approach:
 *
 * 1. True substitutability: Any implementation can be used anywhere
 * 2. No type checking needed in consumer code
 * 3. Consistent behavior across all implementations
 * 4. Adheres to Liskov Substitution Principle
 * 5. Consumer code is simpler and more maintainable
 * 6. Easy to add new implementations without breaking existing code
 */
