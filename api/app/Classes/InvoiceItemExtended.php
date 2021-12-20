<?php

namespace App\Classes;

use Carbon\Carbon;
use Dotenv\Util\Str;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceItemExtended extends InvoiceItem
{
    public $total_time;

    public $rentArea;

    public $vehicleType;

    public $logoMenujuTubaba;

    public $logoItera;

    public $logoDikominfoTubaba;

    public $logoDishub;

    public function totalTime(string $start, string $end)
    {
        $this->total_time = Carbon::parse($start)->diffInMinutes($end);

        return $this;
    }

    public function rentArea(string $rentArea)
    {
        $this->rentArea = $rentArea;

        return $this;
    }

    public function vehicleType(string $vehicleType)
    {
        $this->vehicleType = $vehicleType;

        return $this;
    }

    public function logoMenujuTubaba(string $logoMenujuTubaba)
    {
        $this->logoMenujuTubaba = $logoMenujuTubaba;

        return $this;
    }

    public function getLogoMenujuTubaba()
    {
        $type = pathinfo($this->logoMenujuTubaba, PATHINFO_EXTENSION);
        $data = file_get_contents($this->logoMenujuTubaba);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    public function logoItera(string $logoItera)
    {
        $this->logoItera = $logoItera;

        return $this;
    }

    public function getLogoItera()
    {
        $type = pathinfo($this->logoItera, PATHINFO_EXTENSION);
        $data = file_get_contents($this->logoItera);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    public function logoDishub(string $logoDishub)
    {
        $this->logoDishub = $logoDishub;

        return $this;
    }

    public function getLogoDishub()
    {
        $type = pathinfo($this->logoDishub, PATHINFO_EXTENSION);
        $data = file_get_contents($this->logoDishub);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    public function logoDikominfoTubaba(string $logoDikominfoTubaba)
    {
        $this->logoDikominfoTubaba = $logoDikominfoTubaba;

        return $this;
    }

    public function getLogoDikominfoTubaba()
    {
        $type = pathinfo($this->logoDikominfoTubaba, PATHINFO_EXTENSION);
        $data = file_get_contents($this->logoDikominfoTubaba);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
