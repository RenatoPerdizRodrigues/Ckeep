<?php
	define("ROOT", "http://localhost/ckeep/usuario/");
?>

	<div class="navigationDesktop">
	<nav>
		<ul>
			<li><a href="<?= ROOT ?>index.php">Página Inicial</a></li>
			<li><a href="#">Avisos</a></li>
			<li><a href="<?= ROOT ?>views/gastos/consultagastos.php">Gastos</a></li>
			<li><a href="#">Reclamações</a>
				<ul>
					<li><a href="<?= ROOT ?>views/reclamacao/cadastroreclamacao.php">Cadastrar</a></li>
					<!--Utilizaremos o ID da sessão-->
					<li><a href="<?= ROOT ?>views/reclamacao/consultareclamacao.php?id=1">Consultar</a></li>
				</ul>
			</li>
			<li><a href="<?= ROOT ?>views/avisos/consultaregras.php">Regras</a></li>
			<li><a href="#">Seu Cadastro</a></li>
			<li><a href="<?= ROOT ?>logout.php">Logout</a></li>
		</ul>
	</nav>
	</div>