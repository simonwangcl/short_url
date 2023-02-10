## 仓库
```
http://192.168.2.78/wangcl/shortUrl
git clone http://192.168.2.78/wangcl/shortUrl.git
git clone git@192.168.2.78:wangcl/shortUrl.git

```

## DP. 初次部署
##### DP.1 拉取代码仓库
```
git clone http://61.174.28.126:8178/wangcl/shortUrl.git
git clone git@192.168.2.78:wangcl/shortUrl.git

```

##### DP.2 放入非仓库文件
- .env
- .env 从/env/ 中选择相应环境, 改名为.env

##### DP.3 实时文件夹赋予权限
```
cd /usr/local/www/shortUrl/code
chmod -R 777 storage/
chmod -R 777 bootstrap/

```

##### DP.4 nginx 配置推荐
```
server {
    listen 80 default_server;
    server_name  *.nbmj.cn;
    root   /www/api/code/code/public;
    index index.html index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass	unix:/var/run/php-fpm.sock;
        fastcgi_index	index.php;
        fastcgi_param 	SCRIPT_FILENAME	$document_root$fastcgi_script_name;
        include			fastcgi_params;
    }
}
```
```
server {
    listen 443 ssl default_server;
    server_name  *.nbmj.cn;
    root   /www/api/code/code/public;
    index index.html index.php;

    charset utf-8;

    ssl on;
    ssl_certificate /etc/nginx/ssl/nbmj.cn.crt;
    ssl_certificate_key /etc/nginx/ssl/nbmj.cn.key;


    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass	unix:/var/run/php-fpm.sock;
        fastcgi_index	index.php;
        fastcgi_param 	SCRIPT_FILENAME	$document_root$fastcgi_script_name;
        include			fastcgi_params;
    }
}

```
## USE. 初次使用
#### 路由
```
routes\web.php
```

#### 日志
```
// 记录请求日志
LogBeanHelper::request($request);

// 普通日志
LogBeanHelper::info('post准备', $data, 'HTTP_POST');
```

#### 数据库
```
nbjoinevent.short_url
```

#### 脱离仓库的配置
存放在.env

不同环境的.env 模板存放在 env/


## 2. 请求地址
-- 注意事项！！testUrl需要urlencode

内测
```
https://sd.nbmj.cn/urlToShortUrl?url=testUrl
```
外测
```
https://sp.nbmj.cn/urlToShortUrl?url=testUrl
```
线上
```
https://s.nbmj.cn/urlToShortUrl?url=testUrl
```
## 3. 飞书文档地址
```
https://uuuqjm6ehi.feishu.cn/wiki/wikcnTH6DTTvHudYRbnOSApYEoP#
```
