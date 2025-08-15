<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastros</title>
</head>
<body>

    <p>
        Usuário: <?= isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Desconhecido'; ?>
    </p>
    <p>
        Pefil: <?= isset($_SESSION['perfil']) ? $_SESSION['perfil'] : 'Sem perfil'; ?>
    </p>

    <?php if(!empty($_SESSION['usuario'])): ?>
        <p>
            Usuário: <?= htmlspecialchars($_SESSION['usuario']['nome']) ?>
            (Perfil: <?= htmlspecialchars($_SESSION['usuario']['perfil']) ?>) 
        </p>
    <?php endif; ?>

    <a href="?url=auth&logout=1">Logout</a>

    <h3>Novo Contato</h3>
    <form method="POST" action="?url=contato">
        <input type="text"  name="nome"         placeholder="Nome"      required>
        <input type="text"  name="sobrenome"    placeholder="Sobrenome" required>
        <input type="email" name="email"        placeholder="Email"     required>
        <input type="text"  name="telefone"     placeholder="Telefone"          >

        <button type="submit">Adicionar</button>
    </form>

    <h3>Contatos</h3>
    <?php if(!empty($contatos) && is_array($contatos)): ?>
        <ul>
            <?php foreach ($contatos as $c): ?>
                <li>
                    <?= htmlspecialchars($c['nome']) ?> <?= htmlentities($c['sobrenome']) ?> -
                    <?= htmlspecialchars($c['email']) ?> - <?= htmlentities($c['telefone']) ?>
                    <?php if(!empty($_SESSION['usuario']) && $_SESSION['usuario']['perfil'] === 'admin'): ?>
                        <a href="?url=contato&edit=<?= urlencode($c['id']) ?>">Editar</a>
                        <a href="?url=contatos&delete=<?= urlencode($c['id']) ?>" onclick="return confirm('Confirmar excluir?')">Deletar</a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>    
        </ul>
    <?php else: ?>
        <p>Nenhum contato encontrado.</p>
    <?php endif; ?>
</body>
</html>