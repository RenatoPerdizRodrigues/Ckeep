<?php
	if (!defined('ROOT')) define('ROOT', 'http://localhost/ckeep/');
?>

	<div class="navigationDesktop">
	<nav>
		<ul>
			<li><a href="<?= ROOT ?>usuario/index.php">Página Inicial</a></li>
			<li><a href="#">Avisos</a></li>
			<li><a href="<?= ROOT ?>usuario/views/gastos/consultagastos.php">Gastos</a></li>
			<li><a href="#">Reclamações</a>
				<ul>
					<li><a href="<?= ROOT ?>usuario/views/reclamacao/cadastroreclamacao.php">Cadastrar</a></li>
					<!--Utilizaremos o ID da sessão-->
					<li><a href="<?= ROOT ?>usuario/views/reclamacao/consultareclamacao.php?id=1">Consultar</a></li>
				</ul>
			</li>
			<li><a href="<?= ROOT ?>usuario/views/avisos/consultaregras.php">Regras</a></li>
			<li><a href="#">Seu Cadastro</a></li>
			<li><a href="<?= ROOT ?>usuario/logout.php">Logout</a></li>
		</ul>
	</nav>
	</div>