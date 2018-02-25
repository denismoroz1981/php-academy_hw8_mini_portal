<?php

/**
 * Created by PhpStorm.
 * User: Тарас
 * Date: 23.02.2018
 * Time: 20:16
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
</head>
<body>
<?php

    require_once '_header.php';

?>
<main>
    <?= $content ?>
</main>
<?php

require_once '_footer.php';

?>
</body>
</html>
