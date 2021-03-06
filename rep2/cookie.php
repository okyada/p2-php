<?php
/**
 * rep2 - クッキー認証処理
 *
 * 内部文字エンコーディング: Shift_JIS
 */

require_once __DIR__ . '/../init.php';

$_login->authorize(); // ユーザ認証


// 書き出し用変数

$return_path = 'login.php';
$keep_login = isset($_REQUEST['keep_login']) ? $_REQUEST['keep_login'] : '';
$keep_login = rawurlencode($keep_login);
$next_url = "{$return_path}?check_keep_login=1&keep_login={$keep_login}";
$next_url .= str_replace('&amp;', '&', $_conf['k_at_a']);

header('Location: '.$next_url);
exit;

/*
 * Local Variables:
 * mode: php
 * coding: cp932
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode: nil
 * End:
 */
// vim: set syn=php fenc=cp932 ai et ts=4 sw=4 sts=4 fdm=marker:
