<?php 

function generateDate($data)
{
    $bulan = [
        '01' => 'Januari',
        '02' => 'Febuari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'Novermber',
        '12' => 'Desember',
    ];

    $date = explode('-', $data);

    $text_date = "{$date[2]} {$bulan[$date[1]]} {$date[0]}";

    return $text_date;
}

?>