<!DOCTYPE html>
<html lang="en">
<body>
    <?php
    function psgpjg ($pjg, $lbr) {
        $luas = $pjg * $lbr;
        return $luas;
    }
    $bil1 = 5;
    $bil2 = 3;
    echo "luas persegi panjang dengan pjg 5 dan lebar 3=";
    echo psgpjg($bil1,$bil2);
    ?>
</body>
</html>