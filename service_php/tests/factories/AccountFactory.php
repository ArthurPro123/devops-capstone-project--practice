<?php
class AccountFactory
{
    public static function create($overrides = [])
    {
        $defaults = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'address' => '123 Test St',
            'phone_number' => '1234567890',
        ];
        return array_merge($defaults, $overrides);
    }
}
?>
