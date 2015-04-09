<?php

class P2UtilWiki
{
    /**
     * +Wiki:�v���t�B�[��ID����BEID���v�Z����
     *
     * @return integer|0 ����������BEID��Ԃ��B���s������0��Ԃ��B
     */
    public static function calcBeId($prof_id)
    {
        for ($y = 2; $y <= 9; $y++) {
            for ($x = 2; $x <= 9; $x++) {
                $id = (($prof_id - $x*10.0 - $y)/100.0 + $x - $y - 5.0)/(3.0 * $x * $y);
                if ($id == floor($id)) {
                    return $id;
                }
            }
        }
        return 0;
    }

    /**
     * Wiki:����URL�ɃA�N�Z�X�ł��邩�m�F����
     */
    public static function isURLAccessible($url, $timeout = 7)
    {
        $code = self::getResponseCode($url);
        return ($code == 200 || $code == 206) ? true : false;
    }

    /**
     * URL���C���s�^�Ȃ�true��Ԃ�
     */
    public static function isUrlImepita($url)
    {
        return preg_match('{^http://imepita\.jp/}', $url);
    }

    public static function getResponseCode($url)
    {
        try {
            $req = P2Util::getHTTPRequest2 ($url, HTTP_Request2::METHOD_HEAD);
            return $response->getStatus();

        } catch (Exception $e) {
            return false; // $error_msg
        }
    }

    /**
     * Wiki:Last-Modified���`�F�b�N���ăL���b�V������
     * time:�`�F�b�N���Ȃ�����(unixtime)
     */
    public static function cacheDownload($url, $path, $time = 0)
    {
        $filetime = @filemtime($path);

        // �L���b�V���L�����ԂȂ�_�E�����[�h���Ȃ�
        if ($filetime !== false && $filetime > time() - $time) {
            return;
        }

        // �V������Ύ擾
        P2Util::fileDownload($url, $path);
    }
}