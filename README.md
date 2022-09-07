# php-selen

![license](https://img.shields.io/github/license/hazuki3417/php-selen)
![example workflow](https://github.com/hazuki3417/php-selen/actions/workflows/testing.yml/badge.svg)
![packagest](https://img.shields.io/packagist/v/hazuki3417/php-selen)
![tag](https://img.shields.io/github/v/tag/hazuki3417/php-selen)
![php-version](https://img.shields.io/packagist/php-v/hazuki3417/php-selen)

## Debug

Docker + xdebug + VS Code でステップ実行によるデバッグ環境を構築。
デバッグの手順を以下に記載する。

### デバッグの準備

1. `.vscode/launch.json` ファイルに以下の記述を`configurations`に追加

```json
{
    "name": "php-xdebug",
    "type": "php",
    "request": "launch",
    "port": 9003,
    "pathMappings": {
        "var/www/html/": "${workspaceRoot}"
    }
}
```

2. デバッグ用コンテナを起動
```sh
docker-compose up -d php-xdebug
```

### デバッグの手順

1. ブレークポイント設定

2. デバッグ実行

3. スクリプト実行

```sh
docker-compose exec php-xdebug php examples/index.php
```
## Document

 - [API Reference](https://php-selen.s3.ap-northeast-1.amazonaws.com/phpdoc/index.html)
 - [API Coverage](https://php-selen.s3.ap-northeast-1.amazonaws.com/coverage/index.html)
 - [Packagist](https://packagist.org/packages/hazuki3417/php-selen)
