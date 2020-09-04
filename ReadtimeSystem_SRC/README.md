# humony リードタイムシステム

# 前提（Installが必要なもの）
- docker
    - https://www.docker.com/products/docker-desktop
- docker-compose
    - http://docs.docker.jp/compose/install.html
- VS Code + PHP Debug
    - https://qiita.com/MasanoriIwakura/items/a310c75e6c5b347adf37
- Vagrant
    - https://www.vagrantup.com/
- Virtual box
    - https://www.virtualbox.org/
- Vagrant Plugin
```bash
# Vagrant Plugin Install
vagrant plugin install vagrant-disksize vagrant-docker-compose vagrant-proxyconf vagrant-vbguest vagrant-winnfsd
```

# 環境（2020/4 現在）
- CentOS Linux release 7.7.1908
- Apache 2.4.41
- PHP 7.4.4 (fpm-fcgi) (built: Mar 19 2020 22:16:20)
- Laravel Framework 6.18.3
- PostgreSQL 9.6.9

# ログインについて
基本的にログインしていない場合、エラーではなく、既存のシステムにリダイレクトがかかるようになってます。
- デポの場合
    - /logi/〜
- 社員の場合
    - /KMS/〜
ログイン処理は既存機能からの画面遷移（GET）にて行われます。
- URLの情報
    - URL
http://localhost:8081/logi_improve/login
    - ログインCD
login_cd
    - パスワード
pass
    - 認証区分（社員:1, デポ:2）
auth_cls
※上記はview_login_userのlogin_cd、pass、auth_clsとマッピングしている
- 社員
```
http://localhost:8081/logi_improve/login?login_cd=32&pass=H14AVTqxkp3MvtSqqCAt7u54u%2FhBwwsesTwV9oKXRHZcv4Egr7iPJb1x1LbuFT6fYhjjyUivkCfQbZ5DBUmcKjGjz%2BTOWSX6UrzKZhFw6WMfTRD6S4ZfISBzg9y%2FLEnpn%2FafjE8w2gvAwhol2w7A%2BPPtPxApIIG3Ua2I%2B4cXyPc%3D&auth_cls=1
```

- デポ　通常 【334】カーサポート水戸★
```
http://localhost:8081/logi_improve/login?login_cd=334&pass=TcFMFZojxSG6sq8pbts%2B3U0Ocjowc4zcXyiFb%2B0kDNAQHxsQFIZz892J2ufqCHgnaBUygqmT0sq2ydpOVq%2BfNRmnVUc6N6BGGWb%2BVUdzkvd9zO5q9dw3xLoo25ryh%2FMJPKl%2BHBAR%2F%2BK3zX%2BWzsmjY1n2UBojSe8PGbnLejYozbk%3D&auth_cls=2
```

- デポ　サプライズ　【905】サプライズ東京（アトムロジスティクス）
```
http://localhost:8081/logi_improve/login?login_cd=905&pass=TcFMFZojxSG6sq8pbts%2B3U0Ocjowc4zcXyiFb%2B0kDNAQHxsQFIZz892J2ufqCHgnaBUygqmT0sq2ydpOVq%2BfNRmnVUc6N6BGGWb%2BVUdzkvd9zO5q9dw3xLoo25ryh%2FMJPKl%2BHBAR%2F%2BK3zX%2BWzsmjY1n2UBojSe8PGbnLejYozbk%3D&auth_cls=2
```

- デポ　エンタメ　【1102004】○（翌日お届け）エンタメSBS関東
```
http://localhost:8081/logi_improve/login?login_cd=1102004&pass=TcFMFZojxSG6sq8pbts%2B3U0Ocjowc4zcXyiFb%2B0kDNAQHxsQFIZz892J2ufqCHgnaBUygqmT0sq2ydpOVq%2BfNRmnVUc6N6BGGWb%2BVUdzkvd9zO5q9dw3xLoo25ryh%2FMJPKl%2BHBAR%2F%2BK3zX%2BWzsmjY1n2UBojSe8PGbnLejYozbk%3D&auth_cls=2
```

# 注意事項
- 社内GIT（SCM Manager）では、httpsで接続できない場合があり、その場合はhttpで接続を試みる
https://scm.in.acro-system.com/scm/git/ReadtimeSystem_SRC
http://scm.in.acro-system.com/scm/git/ReadtimeSystem_SRC
※要　VPN
- git からソースを落としてきた場合に改行コードがCRLFになってしまっている場合がある
LFとなるようにする必要がある
※Vs codeで必ず改行コードを確認する
- 開発環境（システムテスト環境）ではhostsの設定が必要
13.230.122.18 syslocal.keicho.net
13.230.122.18 syslocal.verycard.net

# [Mac] Local Dockerのセットアップの場合（またはWindows professionalの場合）
## プロジェクト直下で以下を実行する
```bash
sh ./docker-setup.sh
```
Dokcerのビルド、Laravelのセットアップまで一貫して行うコマンド  
基本的に上記のコマンド後に以下アクセスを行いLaravelの画面が表示されたら環境構築は完了となります。

## 画面確認
```
http://localhost:8081/logi_improve
```
※要　Login

# [Windows Home] Local Vagrantのセットアップの場合
## プロジェクト直下で以下を実行する
```bash
vagrant up
```

## vagrant に入る
```bash
vagrant ssh -c "cd /vagrant; bash"
```

## docker　ビルド
```bash
sh docker-setup.sh
```
Dokcerのビルド、postgreSQLデータ投入、Laravelのセットアップまで一貫して行うコマンド  
基本的に上記のコマンド後に以下アクセスを行いLaravelの画面が表示されたら環境構築は完了となります。

## 画面確認
```
http://localhost:8081/logi_improve
```
※要　Login

# pgadmin4
```
http://localhost:8082/
root / root
```

# 備忘録
## Vagrant コマンド
### 起動
```bash
vagrant up
```
### ssh
```bash
vagrant ssh
```
### 停止
```bash
vagrant halt
```
### 削除
```bash
vagrant destroy
```

## Docker serviceへのログイン
### apache Docker
```bash
docker-compose exec web bash
```
### Laravel Docker
```bash
docker-compose exec php-laravel bash
``` 
### postgresql Docker
``` bash
docker-compose exec postgres bash
``` 
### pgadmin4 Docker
``` bash
docker-compose exec pgadmin4 bash
``` 

## フロント開発について
プロジェクト直下にて以下コマンドを実行するとフロント側のビルドが行われ、resourcesかpublicへソースが反映されます。
``` bash
npm run development
``` 
フロントエンドを中心的に開発する場合は監視設定モードが効率が良い
``` bash
npm run watch
``` 

# ソフトウェア設計手法
ドメイン駆動設計　＋　オニオンアーキテクチャ
※現状 崩壊している

# プロジェクト構成

## Application(app/Application)
ユースケースを格納します。

### Controllers
APIのControllerを格納します。
- XxxxxxxController.php
- 基本的に１リソース　＝　１コントローラー

### Requests
APIのリクエストパラメータクラスを格納します。
- XxxxxxxRequest.php
- RequestクラスのValidationに基本的なチェック処理を記述
- Validationで間に合わない特殊なチェック処理はcustomValidationメソッドで吸収

### Responses
APIのレスポンスパラメータクラスを格納します。
- XxxxxxxResponse.php

### UseCases
アプリケーションロジックを記述したクラスを格納します。
- XxxxxxxUseCase.php
- VersionCheckUseCase.phpなど、ユースケース毎に細分化します
- Interfaceは作成・実装せずに直接クラスを定義します
- ドメインへのアクセスはRepositoriyを使用します

--------------
## Domain(app/Domain)
EntityやModel、Domainへのアクセス（定義のみ）を記載したRepositoryを格納します。

### Model
モデルクラスを格納します。
- クラス名はテーブル名のアッパーキャメルケースとする（device　→　Device）
- Eloquent（ORM）を使用する
- Illuminate\Database\Eloquent\Modelを継承する

### Repositories
ドメインへのアクセスを行う定義（Interface）を記述するクラスを格納します。
- XxxxxxxRepositoryInterface
- Interfaceのみを記述する
- パラメータ、メソッド名、リターンのみを定義する

### Entities
エンティティクラスを格納します。
- XxxxxxxEntity.php
- モデルでは情報が足りない場合、Entityを作成してアプリケーション層に返却する
- アプリケーション層に戻す際、モデルだけでは情報が足りない場合、使用する
- Entitie = Factoryは１対１の関係とする
- Factoryのmakeを経由してEntityは作成する
※検索等大量にデータを扱う場合、Modelのまま返却している箇所がある

### Factories
エンティティを作成するファクトリークラスを格納します。
- XxxxxxxFactory.php
- makeメソッドを必ず作成する

### Value
ValueObjectを格納します。
- ファイル名はMailAddressやDeviceなどの名詞
※現状使っていない

--------------
## Infrastructure(app/Infrastructure)
DB/外部API/ファイルなどにアクセスするクラスを格納します。  
現状はDBへの接続するEloquentのみ

### Eloquent
DBへのアクセスを行うクラスを格納します。
- EloquentXxxxxxxRepository.php
- Repositoriesの実装クラスとなります

--------------
## Console(app/Console)
バッチを格納するが、今回は使用しない

--------------
## Exceptions(app/Exceptions)
エラークラスを格納する
- XxxxxxxException.php
- Handler.phpはLaravelの例外ハンドラとなる

--------------
## Http(app/Http)
ミドルウェアを格納します。
- Kernel.phpにてミドルウェアの管理をする

### Middleware
ミドルウェアはアプリケーションへ送信されたHTTPリクエストをフィルタリングする、便利なメカニズムを提供します。
- 認証やCSRF保護などLaravelに用意されているミドルウェアを格納する

--------------
## Providers(app/Providers)
アプリケーションの初期起動時に必要なサービスプロバイダを管理します。  
それぞれのプロバイダにはサービスコンテナの結合や、イベントリスナ、フィルター、それにルートなどを登録することを一般的に意味しています。

--------------
## routes(routes)
Laravelの全ルート（全てのアクセス）は、このroutesディレクトリに存在するルートファイルで定義されます。  
これらのファイルはフレームワークにより、自動的に読み込まれます。
- 基本的には２つを理解する
    - api.php  
APIのパスを記載する
    - web.php  
View（画面）のパスを記載する

--------------
## Database(database)
テーブル作成やデータ作成に関係するクラスを管理します。
### migrations
アプリで使用するテーブルを作成・変更・削除をするクラスを格納します。
- YYYY_mm_DD_hhMMSS_zzzzz_xxxxx_xxxxxx_xxxxx.php
    - zzzzz = create or update or delete
    - xxxxx_xxxxxx_xxxxx = 任意の文字列

### seeds
UnitTestや初期構築用のデータ作成クラスを格納します。
- XxxxxxxTableSeeder.php
- DatabaseSeeder.phpにはUnitTestで使用するクラスを羅列します

--------------
## tests(tests)
ユニットテストに関するクラスを格納します。

### UnitTest(tests/Unit)
- XxxxxxxTest.php

--------------
## env(env)
環境変数を格納します。
- ローカル環境　Local
- 開発環境　　　Develop
- 検証環境　　　Staging
- 本番環境　　　Production
- env_build.shにてプロジェクト直下の環境変数ファイル（.env）を書き換えます
- ex) 
    - sh ./env/env_build.sh [パラメータ]
    - [パラメータ] = Loacal or Develop or Staging or Production

--------------
## docker(docker)
ローカル環境のDockerに関するファイルを格納します。
### apache
apacheを構成するファイルを格納します。

### php-laravel
php-laravelを構成するファイルを格納します。

### postgres
postgresqlを構成するファイルを格納します。

--------------
### config
Laravelフレームワークの前設定ファイルを格納します。  
DB / File / Mail などの様々な設定を行います。  
情報の取得元は基本的に.envを優先し、存在しない場合にそれぞれ記述されているものが使用されます。

# 命名規則
## 前提
- Upper camel
XxxxYyyy
- Lower camel
xxxxYyyy
- Lower snake
xxxx_yyyy
- Screaming snake
XXXX_YYYY_ZZZZ
- Lower kebab
xxxx-yyyy

## フロント
### HTML
- タグ
Lower kebab
- class
Lower kebab
- id
Lower snake
- name
Lower snake
### Javascript
- メソッド
Lower camel
- 変数
Lower camel
### Blead
- ファイル名
Screaming snake
### Vue
- ファイル名
Upper camel
## サーバー
### PHP
- クラス名
Upper camel
- メソッド
Lower camel
- 変数
Lower camel
- 定数
Lower snake
- 環境変数
Screaming snake
### DB
- DB名
lower snake
- テーブル名
lower snake
- カラム名
lower snake
