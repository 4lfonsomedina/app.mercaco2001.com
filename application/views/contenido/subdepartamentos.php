<table class="table">
			<?php foreach($subdepartamentos as $d){?>
				<tr>
					<td><input type="file" class="p_imagen_dep" accept="image/png, image/jpeg" id_dep="subdep_<?= $d->id_subdepartamento ?>">
						<img id="img_subdep_<?= $d->id_subdepartamento ?>" class="file_camera" src="<?php 
				
							//if(existe_img_producto($p->producto)){ echo base_url('assets/img/productos/').$p->producto.'.png?'.rand(0,1000); }
							if(existe_img_dep('subdep_'.$d->id_subdepartamento)){ echo base_url('assets/img/dep/').'subdep_'.$d->id_subdepartamento.'.png'; }
							else{echo base_url('assets/img/productos/0.png'); }

					?>" height="50" width="50"></td>
					<td><input type="text" class="form-control edit_subdep" value="<?= $d->nombre_subdepartamento ?>" id_subdep="<?= $d->id_subdepartamento ?>"></td>
					
					<td><a href="#" class="btn btn-danger btn_baja_subdep" id_subdep="<?= $d->id_subdepartamento ?>"><i class="fa fa-trash"></i></a></td>
				</tr>
			<?php } ?>
		</table>