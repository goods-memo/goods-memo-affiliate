<?php

namespace goodsmemo\database;

class TransientUtils
{
    public static function setTransient($transient, $value, $expiration)
    {
        /* 一時的にデータベースに情報を保存する。有効期限後、削除される。 */
        $result = set_transient($transient, $value, $expiration); // 失敗したら、falseを返した。

        /* レンタルサーバーのデータベースでは、たまに、有効期限の設定に失敗しているかも？と予想した。
        *  例えば、1日間という有効期限を設定したのに、
        *  その後ずっとget_transient()で情報を取得できているように、思えた。
        */
        if ($result == false) {
            delete_transient($transient);
        }
    }
}
