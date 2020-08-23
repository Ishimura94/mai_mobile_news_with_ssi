<?PHP

$a=0;
$arr[1]=$_POST['a1'];
$arr[2]=$_POST['a2'];
$arr[3]=$_POST['a3'];
$arr[4]=$_POST['a4'];
$arr[5]=$_POST['a5'];
$arr[6]=$_POST['a6'];
$arr[7]=$_POST['a7'];
$arr[8]=$_POST['a8'];
$arr[9]=$_POST['a9'];

for ($i=1;$i<10;$i++) {
    if (!is_numeric($_POST["a".$i])) {
        echo "Неверный ввод.";
        $a=1;
        break;
    }
}

if ($a==0){
    $op=$arr[1]*$arr[5]*$arr[9]+$arr[2]*$arr[6]*$arr[7]+$arr[3]*$arr[4]*$arr[7]-$arr[1]*$arr[6]*$arr[8]-$arr[2]*$arr[4]*$arr[9]-$arr[3]*$arr[5]*$arr[7];
    echo "Опредилитель матрицы равен $op";
}

?>