			<?php
 if(!isset($page_dir))$page_dir="";?>
			<div class="container-fluid expanded-panel">
				<div class="row">
					<div id="logo" class="col-xs-12 col-sm-2">
						<a href="#"><?php echo $_SESSION["setting"]["company_name"]?></a>
					</div>
					<div id="top-panel" class="col-xs-12 col-sm-10">
						<div class="row">
							<div class="col-xs-8 col-sm-4">
								<div id="search">
									<input type="text" placeholder="search"/>
									<i class="fa fa-search"></i>
								</div>
							</div>
							<div class="col-xs-4 col-sm-8 top-panel-right">
								<?php
 if(isset($_SESSION["setting"]["display_cabang_aktif"])&&$_SESSION["setting"]["display_cabang_aktif"]=="off"){echo "&nbsp";}else {$cabang_string="Cabang";if(isset($_SESSION["setting"]["display_cabang_alias"])&&!empty($_SESSION["setting"]["display_cabang_alias"])){$cabang_string=$_SESSION["setting"]["display_cabang_alias"];}?>
								<?php echo $cabang_string?> : <a href="?m=cabang_aktif" class="about"><b><?php echo $_SESSION["cabang"]["nama"]?></b></a>
								<?php
 }?>
								<ul class="nav navbar-nav pull-right panel-menu">
								<!--<li class="hidden-xs">
										<a href="index.html" class="modal-link">
											<i class="fa fa-bell"></i>
											<span class="badge">7</span>
										</a>
									</li>
									<li class="hidden-xs">
										<a class="ajax-link" href="ajax/calendar.html">
											<i class="fa fa-calendar"></i>
											<span class="badge">7</span>
										</a>
									</li>
									<li class="hidden-xs">
										<a href="ajax/page_messages.html" class="ajax-link">
											<i class="fa fa-envelope"></i>
											<span class="badge">7</span>
										</a>
									</li>-->
									<li class="dropdown">
										<a href="#" class="dropdown-toggle account" data-toggle="dropdown">
											<div class="avatar"><img src="<?php echo $page_dir?>contents/image/user/avatar.jpg" class="img-circle" alt="avatar" /></div>
											<i class="fa fa-angle-down pull-right"></i>
											<div class="user-mini pull-right">
												<span class="welcome">Welcome,</span>
												<span><?php echo $_SESSION["login"]["nama"]?></span>
											</div>
										</a>
										<ul class="dropdown-menu">
											<li>
												<a href="?m=profil_aktif">
													<i class="fa fa-user"></i>
													<span>Profile</span>
												</a>
											</li>
											<li>
												<a href="dashboard_logout.php">
													<i class="fa fa-power-off"></i>
													<span>Sign Out</span>
												</a>
											</li>
										</ul>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php /*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/ ?>