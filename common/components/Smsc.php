<?php

namespace common\components;

use Yii;
use yii\helpers\FileHelper;

//define("SMSC_LOGIN", "Natali37");            // логин клиента
//define("SMSC_PASSWORD", "EGENNaK5Q");        // пароль или MD5-хеш пароля в нижнем регистре
define("SMSC_LOGIN", "Ncunion");            // логин клиента
define("SMSC_PASSWORD", "7c3XT3");        // пароль или MD5-хеш пароля в нижнем регистре
define("SMSC_POST", 0);                        // использовать метод POST
define("SMSC_HTTPS", 0);                    // использовать HTTPS протокол
//define("SMSC_CHARSET", "windows-1251");	// кодировка сообщения: utf-8, koi8-r или windows-1251 (по умолчанию)
define("SMSC_CHARSET", "utf-8");            // кодировка сообщения: utf-8, koi8-r или windows-1251 (по умолчанию)
// define("SMSC_DEBUG", 0);				    // флаг отладки
define("SMSC_DEBUG", 1);                    // флаг отладки
define("SMTP_FROM", "api@cp.smsteam.ru");   // e-mail адрес отправителя

/**
 * Class Smsc
 * @package common\components
 */
class Smsc
{
// Функция отправки SMS
//
// обязательные параметры:
//
// $phones - список телефонов через запятую или точку с запятой
// $message - отправляемое сообщение
//
// необязательные параметры:
//
// $translit - переводить или нет в транслит (1,2 или 0)
// $time - необходимое время доставки в виде строки (DDMMYYhhmm, h1-h2, 0ts, +m)
// $id - идентификатор сообщения. Представляет собой 32-битное число в диапазоне от 1 до 2147483647.
// $format - формат сообщения (0 - обычное sms, 1 - flash-sms, 2 - wap-push, 3 - hlr, 4 - bin, 5 - bin-hex, 6 - ping-sms, 7 - mms, 8 - mail, 9 - call)
// $sender - имя отправителя (Sender ID). Для отключения Sender ID по умолчанию необходимо в качестве имени
// передать пустую строку или точку.
// $query - строка дополнительных параметров, добавляемая в URL-запрос ("valid=01:00&maxsms=3&tz=2")
// $files - массив путей к файлам для отправки mms или e-mail сообщений
//
// возвращает массив (<id>, <количество sms>, <стоимость>, <баланс>) в случае успешной отправки
// либо массив (<id>, -<код ошибки>) в случае ошибки

    /**
     * Отпправка смс клиенту на подтверждение регистрации
     */
    public function pushSms($phone, $code)
    {
        $res = $this->send_sms($phone, 'Ваш код подтверждения: ' . $code);
        return $res;
    }

    static $formats = array(1 => "flash=1", "push=1", "hlr=1", "bin=1", "bin=2", "ping=1", "mms=1", "mail=1", "call=1");
    public static function send_sms($phones, $message, $translit = 0, $time = 0, $id = 0, $format = 0, $sender = false)
    {

        $phones = trim($phones);
        $message = trim($message);
        if (empty($phones) || empty($message)) {
            if (SMSC_DEBUG) {
                self::toLog($phones . "\n" . ' [' . $message . '] - empty phones or message' . "\n");

                return false;
            }
        }

        $params = [
            'cost' => 3,
            'phones' => $phones,
            'mes' => $message,
            'translit' => $translit,
            'id' => $id,
        ];
        if ($format > 0) {
            list($k, $v) = explode('=', self::$formats[$format]);
            $params[$k] = $v;
        }
        if ($sender !== false) $params['sender'] = $sender;
        if ($time) $params['time'] = $time;

        $m = self::_smsc_send($params);
        // (id, cnt, cost, balance) или (id, -error)

        if (SMSC_DEBUG) {
            $result = $phones . "\n" . ' [' . $message . ']' . "\n";
            if ($m[1] > 0) {
                $result .= 'Сообщение отправлено успешно. ID: ' . $m[0] . ', всего SMS: ' . $m[1] . ', стоимость: ' . $m[2] . ', баланс: ' . $m[3];
            } else {
                $result .= 'Ошибка';
                $result .= "\n";
                $result .= var_export($m, true);
            }
            $result .= "\n";
            self::toLog($result);
        }

        return (!empty($m) && is_array($m) && isset($m[1]) && $m[1] > 0);
    }

// Функция получения баланса
//
// без параметров
//
// возвращает баланс в виде строки или false в случае ошибки

    public static function get_balance()
    {
        $m = self::_smsc_send_cmd("balance"); // (balance) или (0, -error)

        if (SMSC_DEBUG) {
            if (!isset($m[1]))
                echo "Сумма на счете: ", $m[0], "\n";
            else
                echo "Ошибка №", -$m[1], "\n";
        }

        return isset($m[1]) ? false : $m[0];
    }


// ВНУТРЕННИЕ ФУНКЦИИ

// Функция вызова запроса. Формирует URL и делает 5 попыток чтения через разные подключения к сервису

    public static function _smsc_send($params = [], $name = 'send')
    {
        return self::_smsc_send_cmd($name, http_build_query($params));
    }

    public static function _smsc_send_cmd($cmd, $arg = "", $files = array())
    {
        $params = [
            'login' => SMSC_LOGIN,
            'psw' => SMSC_PASSWORD,
            'charset' => SMSC_CHARSET,
            'fmt' => 1,
        ];
        $url = $_url = (SMSC_HTTPS ? "https" : "http") . "://cp.smsteam.ru/sys/$cmd.php?" . http_build_query($params) . "&" . $arg;
        $i = 0;
        do {
            if ($i++)
                $url = str_replace('://cp.smsteam.ru/', '://www' . $i . '.cp.smsteam.ru/', $_url);

            $ret = self::_smsc_read_url($url, $files, 3 + $i);
        } while ($ret == "" && $i < 5);

        if ($ret == "") {
            if (SMSC_DEBUG) {
                self::toLog('Ошибка чтения адреса: ' . $url . "\n");
            }

            $ret = ","; // фиктивный ответ
        }

        $delim = ",";

        if ($cmd == "status") {
            parse_str($arg, $m);

            if (strpos($m["id"], ","))
                $delim = "\n";
        }

        return explode($delim, $ret);
    }

// Функция чтения URL. Для работы должно быть доступно:
// curl или fsockopen (только http) или включена опция allow_url_fopen для file_get_contents

    public static function _smsc_read_url($url, $files, $tm = 5)
    {
        $ret = "";
        $post = SMSC_POST || strlen($url) > 2000 || $files;

        if (function_exists("curl_init")) {
            static $c = 0; // keepalive

            if (!$c) {
                $c = curl_init();
                curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($c, CURLOPT_CONNECTTIMEOUT, $tm);
                curl_setopt($c, CURLOPT_TIMEOUT, 60);
                curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
            }

            curl_setopt($c, CURLOPT_POST, $post);

            if ($post) {
                list($url, $post) = explode("?", $url, 2);

                if ($files) {
                    parse_str($post, $m);

                    foreach ($m as $k => $v)
                        $m[$k] = isset($v[0]) && $v[0] == "@" ? sprintf("\0%s", $v) : $v;

                    $post = $m;
                    foreach ($files as $i => $path)
                        if (file_exists($path))
                            $post["file" . $i] = function_exists("curl_file_create") ? curl_file_create($path) : "@" . $path;
                }

                curl_setopt($c, CURLOPT_POSTFIELDS, $post);
            }

            curl_setopt($c, CURLOPT_URL, $url);

            $ret = curl_exec($c);
        } elseif ($files) {
            if (SMSC_DEBUG)
                echo "Не установлен модуль curl для передачи файлов\n";
        } else {
            if (!SMSC_HTTPS && function_exists("fsockopen")) {
                $m = parse_url($url);

                if (!$fp = fsockopen($m["host"], 80, $errno, $errstr, $tm))
                    $fp = fsockopen("212.24.33.196", 80, $errno, $errstr, $tm);

                if ($fp) {
                    stream_set_timeout($fp, 60);

                    fwrite($fp, ($post ? "POST $m[path]" : "GET $m[path]?$m[query]") . " HTTP/1.1\r\nHost: cp.smsteam.ru\r\nUser-Agent: PHP" . ($post ? "\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: " . strlen($m['query']) : "") . "\r\nConnection: Close\r\n\r\n" . ($post ? $m['query'] : ""));

                    while (!feof($fp))
                        $ret .= fgets($fp, 1024);
                    list(, $ret) = explode("\r\n\r\n", $ret, 2);

                    fclose($fp);
                }
            } else
                $ret = file_get_contents($url);
        }

        return $ret;
    }

    /**
     * @param string $message
     * @throws \yii\base\Exception
     */
    private static function toLog($message = '')
    {
        $path = Yii::getAlias('@runtime') . '/logs/sms';
        FileHelper::createDirectory($path);
        $filename = 'log_' . date('Y-m-d') . '.log';
        $logPath = $path . '/' . $filename;

        $str = date('Y-m-d H:i:s') . "\n";
        $str .= $message;
        $str .= "\n";

        file_put_contents($logPath, $str, FILE_APPEND | FILE_TEXT | LOCK_EX);
    }
}
