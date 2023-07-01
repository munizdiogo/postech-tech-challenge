
# Tech Challenge - Sistema de Lanchonete

Esta documentação tem o intuito de orientar sobre a configuração e utilização correta do sistema de lanchonete.


## Configuração de Imagem e Containers Docker

Abra o terminal dentro da pasta raiz do projeto e execute o seguinte comando: 

```bash
  docker-compose up -d
```
E aguarde a finalização da execução. 




## Variáveis de Ambiente

Para execução correta desse projeto e a conexão com o banco de dados, você precisará adicionar as seguintes variáveis de ambiente em seu arquivo .env (na raiz do projeto):

`DB_HOST=SERVIDOR-DB`

`DB_NAME=dbpostech`

`DB_USERNAME=root`

`DB_PASSWORD=secret`

`DB_PORT=3306`



## Testes Unitários

Para executar os testes unitários abra o terminal na pasta raiz do projeto e execute o seguinte comando:

```bash
  ./vendor/bin/phpunit --testdox tests --colors
```


## Documentação

[Fluxograma - Realização do Pedido e Pagamento](https://miro.com/app/board/uXjVMAbdRp0=/?share_link_id=567814725228)

[Fluxograma - Preparação do pedido e entrega do pedido](https://miro.com/app/board/uXjVMAaDj1g=/?share_link_id=766010607812)

[Requisições HTTP - Exemplos](https://documenter.getpostman.com/view/14275027/2s93zCXzjp)
