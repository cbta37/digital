<section class="full-box nav-lateral">
			<div class="full-box nav-lateral-bg show-nav-lateral"></div>
			<div class="full-box nav-lateral-content">
				<figure class="full-box nav-lateral-avatar">
					<i class="far fa-times-circle show-nav-lateral"></i>
					<img src="<?php echo SERVER_URL; ?>vistas/assets/avatar/Avatar.png" class="img-fluid" alt="Avatar">
					<figcaption class="roboto-medium text-center">
						<?php echo $_SESSION['nombre_smp']." ".$_SESSION['apellido_smp']; ?> <br><small class="roboto-condensed-light"><?php echo $_SESSION['usuario_smp'] ?> </small>
					</figcaption>
				</figure>
				<div class="full-box nav-lateral-bar"></div>
				<nav class="full-box nav-lateral-menu">
					<ul>
						<li>
							<a href="<?php echo SERVER_URL; ?>home/"><i class="fas fa-home fa-fw"></i> &nbsp; Inicio</a>
						</li>

						<?php if( $_SESSION['privilegio_smp'] == 1 ){ ?>

						<li>
							<a href="#" class="nav-btn-submenu"><i class="fas fa-book fa-fw"></i> &nbsp; Libros <i class="fas fa-chevron-down"></i></a>
							<ul>
								<li>
									<a href="<?php echo SERVER_URL; ?>book-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; Agregar Libros</a>
								</li>
								<li>
									<a href="<?php echo SERVER_URL; ?>book-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista Libros</a>
								</li>			
								<li>
									<a href="<?php echo SERVER_URL; ?>book-search/"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar Libro</a>
								</li>					
							</ul>
						</li>
						<?php } ?>

						<?php if( $_SESSION['privilegio_smp'] == 1 ){ ?>
						<li>
							<a href="#" class="nav-btn-submenu"><i class="fa fa-fw fa-list-ol"></i> &nbsp; Categorías <i class="fas fa-chevron-down"></i></a>
							<ul>
								<li>
									<a href="<?php echo SERVER_URL; ?>category-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; Agregar Categoría</a>
								</li>
								<li>
									<a href="<?php echo SERVER_URL; ?>category-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista Categorías</a>
								</li>
								<li>
									<a href="<?php echo SERVER_URL; ?>category-search/"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar Categoría</a>
								</li>								
							</ul>
						</li>											
						<?php } ?>
						
						<?php if( $_SESSION['privilegio_smp'] == 1 ){ ?>
						<li>
							<a href="#" class="nav-btn-submenu"><i class="fas  fa-user-secret fa-fw"></i> &nbsp; Usuarios <i class="fas fa-chevron-down"></i></a>
							<ul>
								<li>
									<a href="<?php echo SERVER_URL; ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo usuario</a>
								</li>
								<li>
									<a href="<?php echo SERVER_URL; ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de usuarios</a>
								</li>
								<li>
									<a href="<?php echo SERVER_URL; ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar usuario</a>
								</li>
							</ul>
						</li>
						<?php } ?>
						
						<?php if( $_SESSION['privilegio_smp'] == 3 ){ ?>
							<li>
							<a href="<?php echo SERVER_URL."student-book-search/"; ?>"><i class="fas fa-book fa-fw"></i> &nbsp; Libros</a>
							</li>
							<li>
							<a href="<?php echo SERVER_URL."student-category-search/"; ?>"><i class="fa fa-fw fa-list-ol"></i> &nbsp; Categorías</a>
							</li>
						<?php } ?>
						<li>
							<a href="<?php echo SERVER_URL."user-update/".$lc->encryption($_SESSION['id_smp'])."/"; ?>"><i class="fas fa-user fa-fw"></i> &nbsp; Mi perfil</a>
						</li>
					</ul>
				</nav>
			</div>
		</section>