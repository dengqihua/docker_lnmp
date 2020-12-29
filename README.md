# docker lnmp php多版本 环境

>容器构建慢，可以翻墙提速

>docker-composer.yml 文件涉及到项目目录处，需根据自己环境修改

# 包含容器
    nginx，php-fpm，mysql，redis，mongodb
    
## 构建
```
docker-composer build
```

## 启动

```
docker-compose up -d
```

## 查看服务状态

```
docker-compose ps
```

## 查看服务日志

```
docker-compose logs
```

## 停止服务

```bash
docker-compose down
```

## 重启服务

```bash
docker-compose restart
```