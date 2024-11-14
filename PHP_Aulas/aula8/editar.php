<?php
// Conexão com o banco de dados
$servername = "127.0.0.1";
$username = "root"; 
$password = ""; 
$dbname = "meu_banco";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Inicializar a variável $usuario
$usuario = null;

// Verificar se o ID do usuário foi passado e, caso afirmativo, buscar os dados
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM usuarios WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        echo "Usuário não encontrado.";
        exit;
    }
}

// Atualizar os dados do usuário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql = "UPDATE usuarios SET nome='$nome', email='$email' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Usuário atualizado com sucesso!";
        echo "<br><a href='index.php'>Voltar para a lista de usuários</a>";
        exit;
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
</head>
<body>
    <h2>Editar Usuário</h2>
    <?php if ($usuario): // Verificar se o usuário foi encontrado ?>
    <form action="editar.php" method="post">
        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required><br>

        <button type="submit">Salvar Alterações</button>
    </form>
    <?php else: ?>
        <p>Usuário não encontrado.</p>
    <?php endif; ?>

    <br>
    <a href="index.php">Voltar para a lista de usuários</a>

    <?php $conn->close(); // Fechando a conexão com o banco de dados ?>
</body>
</html>
