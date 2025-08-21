<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <?php if(isset($erro)) : ?>
        <p style="color:red;"><?= $erro ?>
    <?php endif; ?>

    <form method="POST" action="?url=auth">
        <label>Email:</label>
        <input type="email" name="email" required /><br>
        <label>Senha:</label>
        <input type="password" name="senha" required /><br>

        <button type="submit">Entrar</button>
    </form>
    
</body>
</html>