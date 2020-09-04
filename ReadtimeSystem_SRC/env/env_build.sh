#!/usr/bin/bash
#envファイルを切り替えるシェルとなります。
#パラメータが存在する場合はパラメータを使用する

# 引数取得
PARAM=$1

# ディレクトリ判定
if [ "$PARAM" = "Production" ]; then
    DIR='Production'
    # Production
elif [ "$PARAM" = "Staging" ]; then
    # Staging
    DIR='Staging'
elif [ "$PARAM" = "Develop" ]; then
    # Develop
    DIR='Develop'
else
    # Local
    DIR='Local'
fi

# ファイルの移動
echo "$DIR 環境用に.envファイルを設定します。"
# ファイルのコピー
cp env/$DIR/.env ./.env
