<?php
class CarParkingLogs
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
            'cpl_id' => 'ID',
            'cpl_enter_date' => 'Giriş Tarihi',
            'cpl_exit_date' => 'Çıkış Tarihi',
            'cpl_total_payment' => 'Ücret',
        ];

        return $ordering;
    }
}
?>
