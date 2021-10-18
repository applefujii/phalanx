# phalanx

アップル共同開発プロジェクトです。

●xamppでのバーチャルホスト設定例

C:\xampp\apache\conf\extra\httpd-vhosts.conf
#----------------------------------------------------------------------------------------------------
<VirtualHost *:80>
DocumentRoot "gitでプロジェクトを展開した場所のフルパス\phalanx\phalanx\public"
ServerName phalanx.com
</VirtualHost>
<Directory "gitでプロジェクトを展開した場所のフルパス\phalanx\phalanx\public">
AllowOverride All
Require all granted
</Directory>
#----------------------------------------------------------------------------------------------------

C:\Windows\System32\drivers\etc\hosts

127.0.0.1 phalanx.com