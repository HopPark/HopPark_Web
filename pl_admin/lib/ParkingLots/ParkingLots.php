<?php
class ParkingLots
{
    /**
     *
     */
    public function __construct()
    {
    }

    /**
     *
     */
    public function __destruct()
    {
    }
    
    /**
     * Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'pl_is_active' => 'Active',
            'pl_name' => 'Name',
            'pl_capacity' => 'Capacity',
            'pl_size' => 'Size',
            'pl_hourly_rate' => 'Hourly Rate',
            'pl_balance' => 'Balance'
        ];

        return $ordering;
    }
}
?>
