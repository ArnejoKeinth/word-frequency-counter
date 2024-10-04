<?php

/**
 * Calculate the total price of items in a shopping cart.
 *
 * @param array $items An array of items, each with 'name' and 'price' keys
 * @return float The total price of all items
 */
function calculateTotalPrice(array $items): float
{
    $total = 0;
    foreach ($items as $item) {
        $total += $item['price'];
    }
    return $total;
}

/**
 * Perform a series of string manipulations.
 *
 * @param string $inputString The input string to be manipulated
 * @return string The modified string
 */
function manipulateString(string $inputString): string
{
    $modifiedString = str_replace(' ', '', $inputString);
    return strtolower($modifiedString);
}

/**
 * Check if a number is even or odd.
 *
 * @param int $number The number to check
 * @return string A message indicating whether the number is even or odd
 */
function checkEvenOrOdd(int $number): string
{
    if ($number % 2 == 0) {
        return "The number {$number} is even.";
    } else {
        return "The number {$number} is odd.";
    }
}

// Example usage of the improved functions

$items = [
    ['name' => 'Widget A', 'price' => 10],
    ['name' => 'Widget B', 'price' => 15],
    ['name' => 'Widget C', 'price' => 20],
];

$totalPrice = calculateTotalPrice($items);
echo "Total price: $" . $totalPrice . "\n";

$inputString = "This is a well-structured program with improved readability.";
$modifiedString = manipulateString($inputString);
echo "Modified string: " . $modifiedString . "\n";

$number = 42;
$evenOddResult = checkEvenOrOdd($number);
echo $evenOddResult . "\n";