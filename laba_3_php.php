<?PHP
    include "listsh.php";
    if (isset ($_COOKIE["goods"])) {
        $arr= explode ('/',$_COOKIE["goods"]);
    }
    if (isset($_POST["yu"])) {
        $arr= array ();
        for ($i=1;$i<11;$i++) {
            if (isset ($_POST[$i])) if ($_POST[$i]=="on") array_push($arr,$i);
        }
        header( 'Location: http://nickserv.mati.su/cart.php');
        setcookie ("goods", implode("/",$arr));
    }
?>
        <form>
            <p><input type="text" maxlength="10" size="13" name="username" placeholder="Логин">
            <input type="password" maxlength="10" size="13" name="password" placeholder="Пароль">
            <input type="submit" value="Войти">
            </p>
        </form>                
        <form method="POST">
            <?PHP if (!isset($arr)) echo "<p>Добавьте что-нибудь в корзину.</p>";elseif(count($arr)==1) ; else echo 'У вас в корзине товаров: '.count($arr).'.';?>
            <input type="submit" value="Корзина" name="yu">
            <table>
                <tr><td>Название</td><td>Описание</td><td>Цена</td><td>Отметить для добавления</td></tr>
            <?PHP
                for ($i=4001;$i<4011;$i++) {
                    $b=$i-4000;
                    echo "<tr><td>".$shop[$i]['name']."</td><td>".$shop[$i]['description']."</td><td>".$shop[$i]['price']."</td><td>".'<input type="checkbox" name="'.$b.'"';
                    if (isset ($arr)) {
                        foreach ($arr as $val) {
                            if (($i-4000)==$val) echo 'checked=checked';
                        }
                    }
                    echo '>'."</td></tr>";
                }
            ?>
            </table>
        </form>