<?php
/**
 * p2 - ボードメニューをHTML表示するクラス(携帯)
 */
class ShowBrdMenuK
{
    var $cate_id; // カテゴリーID

    /**
     * コンストラクタ
     */
    function ShowBrdMenuK()
    {
        $this->cate_id = 1;
    }

    /**
     * 板メニューカテゴリをHTML表示する for 携帯
     *
     * @access  public
     * @return  void
     */
    function printCate(&$categories)
    {
        global $_conf, $list_navi_ht;

        if (!$categories) {
            return;
        }

        // 表示数制限
        $list_disp_from = empty($_GET['from']) ? 1 : $_GET['from'];
        $list_disp_all_num = sizeof($categories);
        $disp_navi = P2Util::getListNaviRange($list_disp_from, $_conf['k_sb_disp_range'], $list_disp_all_num);

        if ($disp_navi['from'] > 1) {
            $mae_ht = <<<EOP
<a href="menu_k.php?view=cate&amp;from={$disp_navi['mae_from']}&amp;nr=1{$_conf['k_at_a']}" {$_conf['accesskey']}="{$_conf['k_accesskey']['prev']}">{$_conf['k_accesskey']['prev']}.前</a>
EOP;
        }
        if ($disp_navi['end'] < $list_disp_all_num) {
            $tugi_ht = <<<EOP
<a href="menu_k.php?view=cate&amp;from={$disp_navi['tugi_from']}&amp;nr=1{$_conf['k_at_a']}" {$_conf['accesskey']}="{$_conf['k_accesskey']['next']}">{$_conf['k_accesskey']['next']}.次</a>
EOP;
        }

        if (!$disp_navi['all_once']) {
            $list_navi_ht = <<<EOP
{$disp_navi['range_st']}{$mae_ht} {$tugi_ht}<br>
EOP;
        }

        foreach ($categories as $cate) {
            if ($this->cate_id >= $disp_navi['from'] and $this->cate_id <= $disp_navi['end']) {
                echo "<a href=\"menu_k.php?cateid={$this->cate_id}&amp;nr=1{$_conf['k_at_a']}\">{$cate->name}</a>($cate->num)<br>\n"; // $this->cate_id
            }
            $this->cate_id++;
        }
    }

    /**
     * 板メニューカテゴリの板をHTML表示する for 携帯
     *
     * @access  public
     * @return  void
     */
    function printIta($categories)
    {
        global $_conf, $list_navi_ht;

        if (!$categories) {
            return;
        }

        foreach ($categories as $cate) {
            if ($cate->num > 0) {
                if ($this->cate_id == $_GET['cateid']) {

                    echo "{$cate->name}<hr>\n";

                    // 表示数制限
                    $list_disp_from = empty($_GET['from']) ? 1 : $_GET['from'];
                    $list_disp_all_num = $cate->num;
                    $disp_navi = P2Util::getListNaviRange($list_disp_from, $_conf['k_sb_disp_range'], $list_disp_all_num);

                    if ($disp_navi['from'] > 1) {
                        $mae_ht = <<<EOP
<a href="menu_k.php?cateid={$this->cate_id}&amp;from={$disp_navi['mae_from']}&amp;nr=1{$_conf['k_at_a']}">前</a>
EOP;
                    }
                    if ($disp_navi['end'] < $list_disp_all_num) {
                        $tugi_ht = <<<EOP
<a href="menu_k.php?cateid={$this->cate_id}&amp;from={$disp_navi['tugi_from']}&amp;nr=1{$_conf['k_at_a']}">次</a>
EOP;
                    }

                    if (!$disp_navi['all_once']) {
                        $list_navi_ht = <<<EOP
{$disp_navi['range_st']}{$mae_ht} {$tugi_ht}<br>
EOP;
                    }

                    $i = 0;
                    foreach ($cate->menuitas as $mita) {
                        $i++;
                        if ($i <= 9) {
                            $access_num_st = "$i.";
                            $akey_at = " {$_conf['accesskey']}=\"{$i}\"";
                        } else {
                            $access_num_st = '';
                            $akey_at = '';
                        }
                        // 板名プリント
                        if ($i >= $disp_navi['from'] and $i <= $disp_navi['end']) {
                            echo "<a href=\"{$_SERVER['SCRIPT_NAME']}?host={$mita->host}&amp;bbs={$mita->bbs}&amp;itaj_en={$mita->itaj_en}&amp;setfavita=1&amp;view=favita{$_conf['k_at_a']}\">+</a> <a href=\"{$_conf['subject_php']}?host={$mita->host}&amp;bbs={$mita->bbs}&amp;itaj_en={$mita->itaj_en}{$_conf['k_at_a']}\"{$akey_at}>{$access_num_st}{$mita->itaj_ht}</a><br>\n";
                        }
                    }

                }
            }
            $this->cate_id++;
        }
    }

    /**
     * 板名を検索してHTML表示する for 携帯
     *
     * @access  public
     * @return  void
     */
    function printItaSearch($categories)
    {
        global $_conf;
        global $list_navi_ht;

        if (!$categories) {
            return;
        }

        // {{{ 表示数制限

        $list_disp_from = empty($_GET['from']) ? 1 : $_GET['from'];
        $list_disp_all_num = $GLOBALS['ita_mikke']['num'];
        $disp_navi = P2Util::getListNaviRange($list_disp_from, $_conf['k_sb_disp_range'], $list_disp_all_num);

        $detect_hint_q = '_hint=' . rawurlencode($_conf['detect_hint']);
        $word_q = '&amp;word=' . rawurlencode($_REQUEST['word']);

        if ($disp_navi['from'] > 1) {
            $mae_ht = <<<EOP
<a href="menu_k.php?w{$detect_hint_q}{$word_q}&amp;from={$disp_navi['mae_from']}&amp;nr=1{$_conf['k_at_a']}">前</a>
EOP;
        }
        if ($disp_navi['end'] < $list_disp_all_num) {
            $tugi_ht = <<<EOP
<a href="menu_k.php?{$detect_hint_q}{$word_q}&amp;from={$disp_navi['tugi_from']}&amp;nr=1{$_conf['k_at_a']}">次</a>
EOP;
        }

        if (!$disp_navi['all_once']) {
            $list_navi_ht = <<<EOP
{$disp_navi['range_st']}{$mae_ht} {$tugi_ht}<br>
EOP;
        }

        // }}}

        $i = 0;
        foreach ($categories as $cate) {

            if ($cate->num > 0) {

                $t = false;
                foreach ($cate->menuitas as $mita) {

                    $GLOBALS['menu_show_ita_num']++;
                    if ($GLOBALS['menu_show_ita_num'] >= $disp_navi['from'] and $GLOBALS['menu_show_ita_num'] <= $disp_navi['end']) {
                        if (!$t) {
                            echo "<b>{$cate->name}</b><br>\n";
                        }
                        $t = true;
                        echo "　<a href=\"{$_conf['subject_php']}?host={$mita->host}&amp;bbs={$mita->bbs}&amp;itaj_en={$mita->itaj_en}{$_conf['k_at_a']}\">{$mita->itaj_ht}</a><br>\n";
                    }
                }

            }
            $this->cate_id++;
        }
    }

    /**
     * お気に板をHTML表示する for 携帯
     *
     * @access  public
     * @return  void
     */
    function printFavItaHtml()
    {
        global $_conf;

        $show_flag = false;

        $lines = @file($_conf['favita_path']); // favita読み込み
        if ($lines) {
            echo 'お気に板 [<a href="editfavita.php?k=1">編集</a>]<hr>';
            $i = 0;
            foreach ($lines as $l) {
                $i++;
                $l = rtrim($l);
                if (preg_match("/^\t?(.+)\t(.+)\t(.+)$/", $l, $matches)) {
                    $itaj = rtrim($matches[3]);
                    $itaj_view = htmlspecialchars($itaj, ENT_QUOTES);
                    $itaj_en = rawurlencode(base64_encode($itaj));
                    if ($i <= 9) {
                        $access_at = " {$_conf['accesskey']}={$i}";
                        $key_num_st = "$i.";
                    } else {
                        $access_at = '';
                        $key_num_st = '';
                    }
                    echo <<<EOP
    <a href="{$_conf['subject_php']}?host={$matches[1]}&amp;bbs={$matches[2]}&amp;itaj_en={$itaj_en}{$_conf['k_at_a']}"{$access_at}>{$key_num_st}{$itaj_view}</a><br>
EOP;
                    //  [<a href="{$_SERVER['SCRIPT_NAME']}?host={$matches[1]}&amp;bbs={$matches[2]}&amp;setfavita=0&amp;view=favita{$_conf['k_at_a']}">削</a>]
                    $show_flag = true;
                }
            }
        }

        if (empty($show_flag)) {
            echo "<p>お気に板はまだないようだ</p>";
        }
    }

}

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
