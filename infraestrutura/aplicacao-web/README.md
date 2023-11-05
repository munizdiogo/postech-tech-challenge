> [!NOTE]
> **Referências:**
> _https://antonputra.com/terraform/how-to-create-eks-cluster-using-terraform/#deploy-eks-cluster-autoscaler_




# CRIANDO A INFRA E SUBINDO A APLICAÇÃO


### 1. Acessar diretório do /aplicacao-web/terraform

```bash
        cd terraform
```


### 2. Iniciar o terraform

```bash
        terraform init
```


### 3. Validar o script do terraform  (OPCIONAL)

```bash
        terraform plan
```


### 4. Executar scripts terraform, para criação da infra

```bash
        terraform apply
```


### 5. Acessar instância EKS através do terminal. Definir "Context" do kubernetes no Docker Desktop

```bash
        aws eks --region us-east-1 update-kubeconfig --name postech
```


### 6. Confirmar a conexão com o cluster do EKS

```bash
        kubectl get svc
```


### 7. Executar o "deployment" e "service" da aplicação (arquivos kubernetes)

```bash
        kubectl apply -f ../k8s/deployment.yaml
        kubectl apply -f ../k8s/public-lb.yaml
        kubectl apply -f ../k8s/private-lb.yaml
```



### 8. Verificar se aplicação foi criada com sucesso. O status precisa estar como "Running"

```bash
        kubectl get pods
```


### 9. Testar se a aplicação está acessível e funcionando, acessando "aplicacaoweb" através do endereço da rede pública

```bash
        kubectl get svc
```


### 10. Atualizar a "annotations" do script do arquivo "cluster-autoscaler.yaml" com o endereço do "arn:aws:iam", 
que é exibido na finalização da criação do ambiente da infra do terraform (após terraform apply).
Deve ser semelhante ao exemplo abaixo.

  >      namespace: kube-system
  >          annotations:
  >              eks.amazonaws.com/role-arn: arn:aws:iam::751916211357:role/eks-cluster-autoscaler"



### 11. Executar comando terraform para aplicar a alteração realizada

```bash
        terraform apply
```


### 12. Executar o "cluster-autoscaler.yaml"

```bash
         kubectl apply -f ../k8s/cluster-autoscaler.yaml
```



----------------------------------------------------------------------



# DELETANDO TODO AMBIENTE NA AWS

### 1. Acessar diretório do /aplicacao-web/terraform

```bash
        cd terraform
```


### 2. Deletar a aplicação do Kubernetes

```bash
        kubectl delete -f ../k8s/deployment.yaml
        kubectl delete -f ../k8s/public-lb.yaml
        kubectl delete -f ../k8s/private-lb.yaml

        kubectl delete -f ../k8s/cluster-autoscaler.yaml
```


### 3. Deletar infraestutura da AWS criada pelo terraform

```bash
        terraform destroy

        kubectl delete -f deployment.yaml
        kubectl delete -f public-lb.yaml
        kubectl delete -f private-lb.yaml

        kubectl delete -f cluster-autoscaler.yaml
```


