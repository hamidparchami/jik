<?php
/**
 * Created by PhpStorm.
 * User: hamid
 * Date: 1/3/17
 * Time: 4:11 PM
 */
return [
    /* identity values */

    'identity_hostname'       => env('IDENTITY_HOSTNAME', 'https://accounts.appson.ir'),
    'identity_app_key'        => env('IDENTITY_APP_KEY', 'Appson-Identity-App-Id:E059E92C-1FEA-4283-9311-8D20DE8DB6D1'),

    'identity_public_key' => env('IDENTITY_PUBLIC_KEY', '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAndWCO3/oeb5gTOxl7iN0
k8YDvreB4IqbEZ55L+IHa7mO/+5N16ArU/OgkjtgOMdv1InA4mW8kxpwMvFsB6WU
Xkv6eVfkTx6QSua1s/Js6caSPoZrp4zuzm5xSqY1dZmfoqGTMR/oR4QxYpQwmH/l
kdRwKU7yv08FdYab8Wy2GkYZzIF0uzms5mx40CpsphjFW9DTwm655FqhrGB5e03/
coQZwqz6dqZOomoTBKXaLNZXrdVFm9iRgky6GfQZ4GE5/OaKjjEWcwu5qgFeqvqw
xQVTnfYotI37Z/uDwzvXA0tZglaqMWxmn+840eDrgtNeQoerYHvUf3BBhmAKEJby
cQIDAQAB
-----END PUBLIC KEY-----'),

    /* VAS services values */
    'MCI_server' => 'http://172.16.41.17:8080',
    'IMI_server' => 'http://172.16.41.18:8002',

    /* phone number patterns */
    'MCI_pattern' => '/^09[1,9]\d{8}$/',
    'MTN_pattern' => '/^09[0,3]\d{8}$/',
    'Rightel_pattern' => '/^092\d{8}$/',

    /* messaging */
    'messaging_public_key' => env('MESSAGING_PUBLIC_KEY', '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAoFfWHW42LN2IAimPFtIK
wW4dHxM34Uo26h8O6moGYVQNkwKBPgLgsoGhJhzNYB0iL26bQKlnbXHdZKFqJ2EO
OoBSyc8MqVix8ICYRX2EFtDh/5SHoOlw5gPfmxz9esy4E2OEaFi4PCGwRQfkE7fe
Y++ZMqlgcj2fqxnURYVRb2dbiT7y09pNQoLNZzOWRJkwcv1m5fOP+TGo3v13lR+V
jpJKHLPq1EKhWmcz25JOiIDUembwt4kzVX5k0L2ylCCOHky7qZEmbwaD96lyqOxW
H8z7w4bI325ECqc8PnOQR7HPZaHD6OQr7rfnkT/eKpTgfSsYzrA7z4jgHJr+R/7A
6wIDAQAB
-----END PUBLIC KEY-----'),

];