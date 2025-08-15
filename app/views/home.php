<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastros</title>
</head>
<body>
    <h1>Bem vindo(a)!</h1>

    <h2>Lista de Contatos</h2>
    <p>Usuário: <?= $_SESSION['usuario']['nome'] ?> (Perfil: <?= $_SESSION['usuario']['perfil'] ?>)</p>
    <a href="?url=auth&logout=1">logout</a>

    <h3>Novo Contato</h3>
    <form method="POST" action="?url=contato">
        <input type="text"  name="nome"         placeholder="Nome"      required>
        <input type="text"  name="sobrenome"    placeholder="Sobrenome" required>
        <input type="email" name="email"        placeholder="Email"     required>
        <input type="text"  name="telefone"     placeholder="Telefone"          >

        <button type="submit">Adicionar</button>
    </form>

    <h3>Contatos</h3>
        <ul>
            <?php foreach($contatos as $c): ?>
                <li>
                    <?= $c['nome'] ?> <?= $c['sobrenome'] ?> - <?= $c['email'] ?> - <?= $c['telefone'] ?>
                    <?php if($_SESSION['usuario']['perfil'] === 'admin'): ?>
                        <a href="?url=contato&edit=<?= $c['id'] ?>">Editar</a>
                        <a href="?url=contato&delete=<?= $c['id'] ?>" onclick="return confirm('Confirmar excluir?')">Deletar</a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
</body>
</html>