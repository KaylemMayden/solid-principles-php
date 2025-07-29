<?php

/**
 * SINGLE RESPONSIBILITY PRINCIPLE - AFTER
 *
 * This example shows how to properly separate responsibilities
 * into focused, single-purpose classes.
 */

/**
 * Defines the contract for sales output formatting
 * Responsibility: Define how sales data should be formatted
 */
interface SalesOutputInterface
{
    public function output($sales);
}

/**
 * HTML-specific output implementation
 * Responsibility: Format sales data as HTML
 */
class HTMLOutput implements SalesOutputInterface
{
    public function output($sales)
    {
        return "<h1>Sales: {$sales}</h1>";
    }
}

/**
 * Additional formatters can be easily added without changing existing code
 * Responsibility: Format sales data as JSON
 */
class JSONOutput implements SalesOutputInterface
{
    public function output($sales)
    {
        return json_encode(['sales' => $sales]);
    }
}

/**
 * CSV output formatter
 * Responsibility: Format sales data as CSV
 */
class CSVOutput implements SalesOutputInterface
{
    public function output($sales)
    {
        return "Sales\n{$sales}";
    }
}

/**
 * Handles all database operations for sales data
 * Responsibility: Data persistence and retrieval
 */
class SalesRepository
{
    public function between($startDate, $endDate)
    {
        // In a real application, this would use a proper database connection
        // For demonstration purposes, we'll simulate the data
        $mockSales = [
            [
                'created_at' => '2024-01-15 14:43:40',
                'charge' => 21100, // in cents
            ],
            [
                'created_at' => '2024-01-20 09:30:00',
                'charge' => 15000,
            ],
            [
                'created_at' => '2024-01-25 16:22:15',
                'charge' => 30500,
            ],
        ];

        // Simple date filtering simulation
        $filteredSales = array_filter($mockSales, function($sale) use ($startDate, $endDate) {
            $saleDate = strtotime($sale['created_at']);
            return $saleDate >= strtotime($startDate) && $saleDate <= strtotime($endDate);
        });

        // Calculate total and convert from cents to dollars
        $total = array_sum(array_column($filteredSales, 'charge')) / 100;

        return $total;
    }
}

/**
 * Coordinates sales reporting workflow
 * Responsibility: Orchestrate the reporting process
 */
class SalesReporter
{
    protected $repo;
    protected $formatter;

    public function __construct(SalesRepository $repo, SalesOutputInterface $formatter)
    {
        $this->repo = $repo;
        $this->formatter = $formatter;
    }

    /**
     * Now, SalesReporter doesn't care how we format the data.
     * It only cares that whatever implementation we use adheres to the contract and has an output method.
     */
    public function reportBetween($startDate, $endDate)
    {
        $sales = $this->repo->between($startDate, $endDate);
        return $this->formatter->output($sales);
    }
}

/**
 * Benefits of this approach:
 *
 * 1. Single Responsibility: Each class has one clear purpose
 * 2. Easy to test: Each component can be tested independently
 * 3. Flexible: Can easily swap formatters or data sources
 * 4. Extensible: New formatters can be added without changing existing code
 * 5. Reusable: Components can be used in different contexts
 * 6. Maintainable: Changes to one responsibility don't affect others
 */
