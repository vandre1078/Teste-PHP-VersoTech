Segue os queries solicitadas no exercicio solicitado. 

-- ==========================================
-- Vendedores Ativos
-- Lista todos os vendedores que estão ativos (inativo = FALSE)
-- Mostrando id, nome e salário, ordenados pelo nome em ordem ascendente
-- ==========================================

SELECT id_vendedor AS id, nome, salario
FROM vendedores
WHERE inativo = FALSE
ORDER BY nome ASC;


-- ==========================================
-- Funcionários com Salário Acima da Média
-- Lista os vendedores que possuem salário acima da média de todos os vendedores
-- Mostrando id, nome e salário, ordenados pelo salário em ordem decrescente
-- ==========================================

SELECT id_vendedor AS id, nome, salario
FROM vendedores
WHERE salario > (SELECT AVG(salario) FROM vendedores)
ORDER BY salario DESC;


-- ==========================================
-- Resumo por Cliente
-- Lista todos os clientes com o valor total dos pedidos
-- Utiliza LEFT JOIN para incluir clientes sem pedidos (total = 0)
-- Mostra id, razao_social e total, ordenados pelo total em ordem decrescente
-- ==========================================

SELECT c.id_cliente AS id, c.razao_social, 
       COALESCE(SUM(p.valor_total), 0) AS total
FROM clientes c
LEFT JOIN pedido p 
       ON c.id_cliente = p.id_cliente
GROUP BY c.id_cliente, c.razao_social
ORDER BY total DESC;


-- ==========================================
-- Situação por Pedido
-- Lista a situação de cada pedido com base nas datas:
--   - CANCELADO se data_cancelamento preenchida
--   - FATURADO se data_faturamento preenchida
--   - PENDENTE caso não tenha nem faturamento nem cancelamento
-- Mostra id, valor, data e situacao, ordenados pelo id do pedido
-- ==========================================

SELECT id_pedido AS id, valor_total AS valor, data_emissao AS data,
       CASE
           WHEN data_cancelamento IS NOT NULL THEN 'CANCELADO'
           WHEN data_faturamento IS NOT NULL THEN 'FATURADO'
           ELSE 'PENDENTE'
       END AS situacao
FROM pedido
ORDER BY id_pedido;


-- ==========================================
-- Produto Mais Vendido
-- Retorna o produto mais vendido em quantidade
-- Inclui quantidade total vendida, valor total, número de pedidos e clientes distintos
-- Critério de desempate: total_vendido
-- ==========================================
SELECT ip.id_produto,
       SUM(ip.quantidade) AS quantidade_vendida,
       SUM(ip.quantidade * ip.preco_praticado) AS total_vendido,
       COUNT(DISTINCT ip.id_pedido) AS pedidos,
       COUNT(DISTINCT ped.id_cliente) AS clientes
FROM itens_pedido ip
JOIN pedido ped ON ip.id_pedido = ped.id_pedido
GROUP BY ip.id_produto
ORDER BY quantidade_vendida DESC, total_vendido DESC
LIMIT 1;




# Teste de conhecimentos PHP + Banco de dados
##### Objetivo
Criar um Crud simples, totalmente desenvolvido em PHP, sem a utilização de frameworks, onde será possível Criar/Editar/Excluir/Listar usuários. O sistema também deve possuir a possibilidade de vincular/desvincular várias cores ao usuário.

##### Estrutura de banco de dados
A seguinte estrutura será utilizada para persistência dos dados, podendo ser alterada a qualquer momento para melhor funcionamento do sistema:

```sql
    tabela: users
        id      int not null auto_increment primary key
        name    varchar(100) not null
        email   varchar(100) not null
```
```sql
    tabela: colors
        id      int not null auto_increment primary key
        name    varchar(50) not null
```
```sql
    tabela: user_colors
        color_id  int
        user_id   int
```

##### Start
Este projeto conta com uma base sqlite com alguns registros já inseridos. Para início das atividades, use como base o arquivo `index.php`, este é apenas um arquivo exemplo onde é aberta conexão com o banco de dados e lista os usuários em uma tabela.

##### Pontos que serão levados em conta
- Funcionalidade
- Organização do código e projeto
- Apresentação da interface (Poderá usar frameworks CSS como Bootstrap, Material, Foundation etc)

##### Dicas
- Para utilizar o banco de dados contido na pasta `database/db.sqlite` é necessário que a sua instalação do php tenha a extensão do sqlite instalada e ativada
- O Php possui um servidor embutido, você consegue dar start ao projeto abrindo o terminal de comando na pasta baixada e executando `php -S 0.0.0.0:7070` e em seguida abrir o navegador em `http://localhost:7070`

##### Boa Sorte
Use seu conhecimento, consulte a documentação e o google, caso ainda houver dúvidas, nos pergunte :D. Boa sorte!
