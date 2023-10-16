<?php

// deklarasi pola
$pola = [1, 9, 2, 10]; 

// hitung panjang pola
$panjang = count($pola);

// cetak pola
for($i = 0; $i < $panjang; $i++) {
  echo $pola[$i] . " ";
}

// cari selisih antara bilangan terakhir dan sebelumnya
$selisih = $pola[$panjang-1] - $pola[$panjang-2]; 

// bilangan berikutnya = bilangan terakhir + selisih
$berikutnya = $pola[$panjang-1] + $selisih;
echo $berikutnya . " "; 

// bilangan berikutnya lagi = sebelumnya + selisih
$berikutnyaLagi = $berikutnya + $selisih;
echo $berikutnyaLagi;

?>