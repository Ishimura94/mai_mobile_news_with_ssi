<?PHP
    include "listsh.php";
    if (isset($_COOKIE["goods"]))$arr = explode ("/",$_COOKIE["goods"]);
    if (isset($_POST["yu"])) {
        for ($i=0;$i<4011;$i++) {
            if(isset($_POST[$i])) if(($key = array_search($i, $arr)) !== false) unset($arr[$key]);
        }
        setcookie ("goods", implode("/",$arr));
    }
    if (isset($_POST["yus"])) header( 'Location: http://nickserv.mati.su/laba_3_php.php');
    ?>
    <?PHP if(empty($arr)) echo "<p>Корзина пуста</p>"; elseif (count($arr)==1) echo "В корзине 1 товар"; else echo "<p>Товаров в корзине: ".count($arr)."."."</p>";?>
    <form method="POST">
    <table>
            <tr><td>Название</td><td>Описание</td><td>Цена</td><td>Отметить для удаления</td></tr>
    <?PHP
    foreach ($arr as $i) {
        $b=$i+4000;
        echo "<tr><td>".$shop[$b]['name']."</td><td>".$shop[$b]['description']/*."</td><td>"."foo"*/."</td><td>".$shop[$b]['price']."</td><td>".'<input type="checkbox" name="'.$i.'">'."</td></tr>";
    }
        ?>
    </table>
        <p>Можно выбрать товары, которые вы хотите удалить из корзины.</p>
        <input type="submit" value="Удалить" name="yu">
        <input type="submit" value="Вернуться в магазин" name="yus">
        </form>