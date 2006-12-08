<?php
/*
    cmd 引き数でコマンド分け
    返り値は、テキストで返す
*/

include_once './conf/conf.inc.php';

$_login->authorize(); // ユーザ認証

// {{{ HTTPヘッダとXML宣言

P2Util::header_nocache();
header('Content-Type: text/html; charset=Shift_JIS');

// }}}

$r_msg = '';

// cmdが指定されていなければ、何も返さずに終了
if (!isset($_GET['cmd']) && !isset($_POST['cmd'])) {
    die('');
}

// コマンド取得
if (isset($_GET['cmd'])) {
    $cmd = $_GET['cmd'];
} elseif (isset($_POST['cmd'])) {
    $cmd = $_POST['cmd'];
}

// {{{ ログ削除

if ($cmd == 'delelog') {
    if (isset($_REQUEST['host']) && isset($_REQUEST['bbs']) && isset($_REQUEST['key'])) {
        include_once P2_LIBRARY_DIR . '/dele.inc.php';
        $r = deleteLogs($_REQUEST['host'], $_REQUEST['bbs'], array($_REQUEST['key']));
        if ($r == 1) {
            $r_msg = "1"; // 完了
        } elseif ($r == 2) {
            $r_msg = "2"; // なし
        } else {
            $r_msg = "0"; // 失敗
        }
    }

// }}}
// {{{ お気にスレ

} elseif ($cmd == 'setfav') {
    if (isset($_REQUEST['host']) && isset($_REQUEST['bbs']) && isset($_REQUEST['key']) && isset($_REQUEST['setfav'])) {
        include_once P2_LIBRARY_DIR . '/setfav.inc.php';
        if (isset($_REQUEST['setnum'])) {
            $r = setFav($_REQUEST['host'], $_REQUEST['bbs'], $_REQUEST['key'], $_REQUEST['setfav'], $_REQUEST['setnum']);
        } else {
            $r = setFav($_REQUEST['host'], $_REQUEST['bbs'], $_REQUEST['key'], $_REQUEST['setfav']);
        }
        if (empty($r)) {
            $r_msg = "0"; // 失敗
        } elseif ($r == 1) {
            $r_msg = "1"; // 完了
        }
    }

// }}}
// {{{ スレッドあぼーん

} elseif ($cmd == 'taborn') {
    if (isset($_REQUEST['host']) && isset($_REQUEST['bbs']) && isset($_REQUEST['key']) && isset($_REQUEST['taborn'])) {
        include_once P2_LIBRARY_DIR . '/settaborn.inc.php';
        $r = settaborn($_REQUEST['host'], $_REQUEST['bbs'], $_REQUEST['key'], $_REQUEST['taborn']);
        if (empty($r)) {
            $r_msg = "0"; // 失敗
        } elseif ($r == 1) {
            $r_msg = "1"; // 完了
        }
    }

// }}}
// {{{ 書き込みフォームのオートセーブ（※これは使っていない。通信負荷を避けて、クッキーにまかせた）

} elseif ($cmd == 'auto_save_post_form') {
    // 未実装のテスト
    ob_start();
    var_dump($_POST);
    $r_msg = ob_get_clean();

}
// }}}
// {{{ 結果出力

if (P2Util::isBrowserSafariGroup()) {
    $r_msg = P2Util::encodeResponseTextForSafari($r_msg);
}
echo $r_msg;

// }}}

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
