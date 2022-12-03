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
            'pl_id' => 'ID',
            'pl_is_active' => 'Aktiflik Durumu',
            'pl_name' => 'İsim',
            'pl_capacity' => 'Kapasite',
            'pl_size' => 'Doluluk',
            'pl_hourly_rate' => 'Saatlik Ücret'
        ];

        return $ordering;
    }
}
?>
