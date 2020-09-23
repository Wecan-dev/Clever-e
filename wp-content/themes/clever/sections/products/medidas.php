<div class="categories-sidebar__size">
	<img src="<?php echo get_template_directory_uri();?>/assets/img/categorie/size.png">
	<div class="categories-sidebar__text">
		<p><?php if(lang() == 'es'){echo "Tabla de medidas de <br> acuerdo con tu cuerpo";}else{echo "Measurement table <br> according to your body";} ?></p>
		<a data-target="#exampleModal" data-toggle="modal"><?php if(lang() == 'es'){echo "VER MÁS";}else{echo "SEE MORE";} ?></a>
	</div>
	<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade modal-size" id="exampleModal" role="dialog" tabindex="-1">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button">
					<span aria-hidden="true">×</span>
				</button>
				<div class="modal-body">
					<h2 class="modal-size__title">
						<?php if(lang() == 'es'){echo "Tabla de <br><span>Medidas</span>";}else{echo "measurement <br><span>table</span>";} ?>
					</h2>
					<div class="modal-size-tab">
						<img src="<?php echo get_template_directory_uri();?>/assets/img/categorie/lines.png">
						<p class="modal-size__header">
							<?php if(lang() == 'es'){echo "Prendas inferiores";}else{echo "Lower garments";} ?>
						</p>
						<div class="modal-size__ref">
							<div class="modal-size__item">
								<p><?php if(lang() == 'es'){echo "Categorías";}else{echo "Categories";} ?></p>
							</div>
							<div class="modal-size__item">
								<p>S</p>
							</div>
							<div class="modal-size__item">
								<p>M</p>
							</div>
							<div class="modal-size__item">
								<p>L</p>
							</div>
							<div class="modal-size__item">
								<p>XL</p>
							</div>
						</div>
						<div class="modal-size__row">
							<div class="modal-size__row--item">
								<p><?php if(lang() == 'es'){echo "Cintura";}else{echo "Waist";} ?></p>
							</div>
							<div class="modal-size__row--item">
								<p>28-30</p>
							</div>
							<div class="modal-size__row--item">
								<p>30-32</p>
							</div>
							<div class="modal-size__row--item">
								<p>32-36</p>
							</div>
							<div class="modal-size__row--item">
								<p>34-36</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>