<?php
	if (!defined('ROOT')) define('ROOT', 'http://localhost/ckeep/');
	$mesanterior = date("m",strtotime(date('Y-m-d')));
	$mesanterior--;
	if ($mesanterior == 0){
		$mesanterior = 1;
		$ano = date("y",strtotime(date('Y-m-d')));
		$ano--;
	} else { $ano = date("y",strtotime(date('Y-m-d')));}
	$ano += 2000;
	$data = "$ano-$mesanterior-30";
?>
	<div class="header">
		<div class="container">
			<div class="titleBar">
				<h1>CKeep</h1>
				<div class="rightSide"><a class="button buttonLogout" href="<?= ROOT ?>logout.php">Logout</a> 
				<div class="hamburger">
					<span class="line"></span>
					<span class="line"></span>
					<span class="line"></span>
				</div>
				</div>
			</div>

			<div class="navigationDesktop">
				<nav>
					<ul>
						<li><a href="<?= ROOT ?>usuario/index.php">Página Inicial</a></li>
						<li><a href="<?= ROOT ?>usuario/views/avisos/consultaavisoativo.php">Comunicação</a>
							<ul>
								<li><a href="<?= ROOT ?>usuario/views/avisos/consultaavisoativo.php">Avisos</a></li>
								<li><a href="#">Reclamações</a>
									<ul>
										<li><a href="<?= ROOT ?>usuario/views/reclamacao/cadastroreclamacao.php">Cadastrar</a></li>
										<li><a href="<?= ROOT ?>usuario/views/reclamacao/consultareclamacao.php?id=1">Consultar</a></li>
									</ul>
                        		</li>
							</ul>
						</li>
					
						<li><a href="<?= ROOT ?>usuario/views/gastos/consultagastos.php?datag=<?= $data; ?>">Gastos</a></li>
                        <li><a href="<?= ROOT ?>usuario/views/avisos/consultaregras.php">Regras</a></li>
                        <li><a href="<?= ROOT ?>usuario/views/cadastro/editarcadastro.php">Editar Cadastro</a></li>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>