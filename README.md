
# Tech Challenge - Sistema de Lanchonete

Esta documentação tem o intuito de orientar sobre a configuração e utilização correta do sistema de lanchonete.


## CRIAR CONTAINERS, POD, SERVICE, DEPLOY
```bash
kubectl apply -f mysql-pv.yaml
kubectl apply -f mysql-service.yaml
kubectl apply -f mysql-deploy.yaml
kubectl apply -f php-service.yaml
kubectl apply -f php-deploy.yaml
```

## Verificar se ambiente foi criado
```bash
kubectl cluster-info
kubectl get po
kubectl get svc
```


## Variáveis de Ambiente

Para execução correta desse projeto e a conexão com o banco de dados, abra o Terminal dentro do container k8s_webserver_aplicacaoweb, execute o comando abaixo para ir para o diretório correto: 

```bash
  cd /var/www/html
```

Em seguida verifique se já existe o arquivo com o nome ".env", caso não exista deverá ser criado com o conteúdo abaixo: 

```bash
  DB_HOST=mysql
  DB_NAME=dbpostech
  DB_USERNAME=root
  DB_PASSWORD=secret
  DB_PORT=3306
  CHAVE_SECRETA=SUA_CHAVE_SECRETA
```




## Testes Unitários

Para executar os testes unitários abra o Terminal dentro do container SERVIDOR-WEB, execute o comando abaixo para ir para o diretório correto: 

```bash
  cd /var/www/html
```

Em seguida execute o seguinte comando:

```bash
  ./vendor/bin/phpunit --testdox tests --colors
```



## Documentação

[Fluxograma - Realização do Pedido e Pagamento](https://miro.com/app/board/uXjVMAbdRp0=/?share_link_id=567814725228)

[Fluxograma - Preparação do pedido e entrega do pedido](https://miro.com/app/board/uXjVMAaDj1g=/?share_link_id=766010607812)

[Requisições HTTP - Exemplos](https://documenter.getpostman.com/view/14275027/2s93zCXzjp)