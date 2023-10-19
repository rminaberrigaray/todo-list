<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$title = 'To Do list CakePHP + Vue.js';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->AssetMix->css('app.css') ?>
    <?= $this->fetch('meta') ?>
</head>
<body class="bg-teal-50 dark:bg-gray-800">
    <div class="">
        <?= $this->fetch('content') ?>
    </div>
    <?= $this->AssetMix->script('app') ?>
    <footer>
    </footer>
</body>
</html>
