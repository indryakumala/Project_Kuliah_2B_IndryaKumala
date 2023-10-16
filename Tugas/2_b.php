<?php

// Pola angka 
$pola = [2, 2, 3, 3, 4];

// Dapatkan panjang pola
$panjangPola = count($pola);

// Angka selanjutnya adalah angka terakhir + 1 
$angkaBerikutnya = $pola[$panjangPola-1] + 1;

// Tampilkan pola
for($i=0; $i<$panjangPola; $i++) {
  echo $pola[$i] . " "; 
}

// Tampilkan angka selanjutnya
echo "$angkaBerikutnya ";

// Angka selanjutnya lagi adalah sebelumnya + 1
$angkaBerikutnya++;
echo $angkaBerikutnya;

?>