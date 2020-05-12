# ステータスコードチェッカー

## はじめに

URL リストから HTTP ステータスコードを一覧で取得するプログラム  
リダイレクト設定の確認用として作成、BASIC 認証のかかったサイトに対しても動作します。

## 使い方

```shell
    Status Code Checker

    Options:
        -f  URLリストファイルを指定

        -e  エクスポート形式を指定
            debug(default)
            csv
            html
            json
            backlog

        -b  BASIC認証

    ex.> $ php this.php -f sample_url.list -e json -b USER:PASSWORD
```

実行例  
backlog のテーブル形式で出力した結果

```shell
$ php StatusCodeChecker.php -f sample_url.list -e backlog
|開始URL|ステータス|リダイレクト先（チェーンの場合は行追加）|ステータス|h
|http://www.senku.jp|301|https://www.senku.jp/|200|
|http://google.com|301|http://www.google.com/|200|
|http://yahoo.co.jp|301|https://www.yahoo.co.jp/|200|
```

## 免責
