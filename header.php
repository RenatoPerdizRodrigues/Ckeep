<?php
	if (!defined('ROOT')) define('ROOT', 'http://localhost/ckeep/');
?>

	<div class="navigationDesktop">
	<nav>
		<ul>
			<li><a href="<?= ROOT ?>index.php">Página Inicial</a></li>
			<li><a href="#">Cadastro</a>
				<ul>
					<li><a href="#">Condômino</a>
						<ul>
							<li><a href="<?= ROOT ?>views/condomino/cadastrocondomino.php">Cadastrar</a></li>
							<li><a href="<?= ROOT ?>views/condomino/consultacondomino.php">Consultar</a></li>
						</ul>
					</li>
					<li><a href="#">Funcionário</a>
						<ul>
							<li><a href="<?= ROOT ?>views/funcionario/cadastrofuncionario.php">Cadastrar</a></li>
							<li><a href="<?= ROOT ?>views/funcionario/consultafuncionario.php">Consultar</a></li>
						</ul>
					</li>
					<li><a href="<?= ROOT ?>">Veículo</a>
						<ul>
							<li><a href="<?= ROOT ?>views/veiculo/localizacaocadastroveiculo.php">Cadastrar</a></li>
							<li><a href="<?= ROOT ?>views/veiculo/consultaveiculo.php">Consultar</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<li><a href="#">Apartamentos</a>
				<ul>
					<li><a href="<?= ROOT ?>views/moradores/consultamoradores.php">Moradores</a></li>
					<li><a href="<?= ROOT ?>views/statuspagador/consultastatuspagador.php">Status de Pagador</a></li>
				</ul>
			</li>
			<li><a href="#">Financeiro</a>
				<ul>
					<li><a href="<?= ROOT ?>views/previsao/consultaprevisao.php">Previsão de Gastos</a></li>
					<li><a href="<?= ROOT ?>">Gasto</a>
						<ul>
							<li><a href="<?= ROOT ?>views/previsao/consultagasto.php">Consultar</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<li><a href="#">Comunicação</a>
				<ul>
					<li><a href="<?= ROOT ?>">Reclamações</a></li>
					<li><a href="<?= ROOT ?>">Avisos</a>
						<ul>
							<li><a href="<?= ROOT ?>views/aviso/cadastroaviso.php">Cadastrar</a></li>
							<li><a href="<?= ROOT ?>views/aviso/consultaaviso.php">Consultar</a></li>
						</ul>
					</li>
				</ul>
			</li>
		</ul>
	</nav>
	</div>