<?php

/**
 * SINGLE RESPONSIBILITY PRINCIPLE - BEFORE
 *
 * This class violates SRP by having multiple responsibilities:
 * 1. Authentication logic
 * 2. Database access
 * 3. Output formatting
 * 4. Business logic coordination
 */

class SalesReporter
{
    public function between($startDate, $endDate)
    {
        // Why would the sales Reporter care about this? This is application logic.
        // Is it possible that we could consume this SalesReporter class without having an authenticated user?
        if (! Auth::check()) throw new Exception('Auth required');

        // Data access responsibility mixed with business logic
        $sales = $this->queryDatabaseForSalesBetween($startDate, $endDate);

        // Output formatting responsibility
        return $this->format($sales);
    }

    // Database logic doesn't belong in a "Reporter"
    protected function queryDatabaseForSalesBetween(Carbon $startDate, Carbon $endDate)
    {
        // Hard-coded database logic makes this untestable and inflexible
        return collect([
            [
                'created_at' => new Carbon('2021-03-19 14:43:40'),
                'charge' => '211',
            ],
        ])->whereBetween('created_at', [$startDate, $endDate])->sum('charge') / 100;
    }

    // If we wanted to change the way we format the output, this class would have to change
    // Why should this class care? Why should it be responsible for outputting, formatting, or printing the results?
    protected function format(float $sales)
    {
        return "<h1>Sales: $sales</h1>";
    }
}

/**
 * Problems with this approach:
 *
 * 1. Multiple responsibilities in one class
 * 2. Hard to test (authentication, database, formatting all coupled)
 * 3. Hard to change (changing output format requires modifying this class)
 * 4. Inflexible (can't reuse parts independently)
 */
