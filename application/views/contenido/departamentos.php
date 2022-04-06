<form id="img_dep_form">
				<input type="hidden" id="nombre_depsubdep" name="nombre">
				<input type="hidden" id="imagen_base64" name="imagen_base64">
</form>
<form id="img_dep_form">
				<input type="hidden" id="input_nombre_departamento" name="nombre_departamento">
				<input type="hidden" id="input_id_departamento" name="id_departamento">
				<input type="hidden" id="input_color" name="color">
</form>
<center><canvas id= "canvas_img" height="300" width="300" hidden></canvas></center>

<div class="col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
			DEPARTAMENTOS 
			<a class="btn btn-success btn-xs pull-right" id="btn_alta_dep"><i class="fa fa-plus"></i></a>
		</div>
		<div class="panel-body">
			<table class="table">
				<?php foreach($departamentos as $d){?>
					<tr class="tr_dep" id_dep="<?= $d->id_departamento ?>">
						<td><input type="file" class="p_imagen_dep" accept="image/png, image/jpeg" id_dep="dep_<?= $d->id_departamento ?>">
						<img id="img_dep_<?= $d->id_departamento ?>" class="file_camera" src="<?php 
				
							//if(existe_img_producto($p->producto)){ echo base_url('assets/img/productos/').$p->producto.'.png?'.rand(0,1000); }
							if(existe_img_dep('dep_'.$d->id_departamento)){ echo base_url('assets/img/dep/').'dep_'.$d->id_departamento.'.png'; }
							else{echo base_url('assets/img/productos/0.png'); }

					?>" height="50" width="50"></td>
					<form id="form_dep_<?= $d->id_departamento ?>">
						<input type="hidden" name="id_departamento" value="<?= $d->id_departamento ?>">
						<td><input type="color" name="color" class="edit_dep" value="<?= $d->color ?>" id_dep="<?= $d->id_departamento ?>"></td>
						<td><input type="text" name="nombre_departamento" class="form-control edit_dep" value="<?= $d->nombre_departamento ?>" id_dep="<?= $d->id_departamento ?>">
						</td>
						<td><a href="#" class="btn btn-danger btn_baja_dep" id_dep="<?= $d->id_departamento ?>"><i class="fa fa-trash"></i></a>
						</td>
					</form>
					</tr>
				<?php } ?>
			</table>
		</div>
	</div>
</div>
<div class="col-md-6">
	<input type="hidden" id="departamento_actual">
	<div class="panel panel-primary panel_subdep" hidden>
		<div class="panel-heading">SUBDEPARTAMENTOS
			<a class="btn btn-success btn-xs pull-right" id="btn_alta_subdep"><i class="fa fa-plus"></i></a>
		</div>
		<div class="panel-body" id="cont_subdepartamentos">
			
		</div>
		
	</div>
</div>



<!-- Modal Alta  -->
<div id="modal_alta_departamento" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align: center">ALTA DE DEPARTAMENTO</h4>
      </div>
      <div class="modal-body" style="overflow-y: auto; background-color: #eaeaea; padding: 30px">
      	<form id="form_alta_dep" action="<?= site_url('Control_controller/alta_departamento')?>" method="POST">
      		<div class="row">
      			<div class="col-md-3">
      				Color<br>
      				<input type="color" name="color">
      			</div>
      			<div class="col-md-9">
      				Nombre Departamento
      				<input type="text" name="nombre_departamento" class="form-control">
      			</div>
      		</div>
	    </form>
	    <br><br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success btn_form_alta_dep">Guardar</button>
      </div>
    </div>

  </div>
</div>



<!-- Modal Alta  -->
<div id="modal_alta_subdepartamento" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align: center">ALTA DE SUBDEPARTAMENTO</h4>
      </div>
      <div class="modal-body" style="overflow-y: auto; background-color: #eaeaea; padding: 30px">
      		<input type="hidden" id="f_id_dep" name="id_departamento">
      		<div class="row">
      			<div class="col-md-12">
      				Nombre Subdepartamento
      				<input type="text" name="nombre_departamento" class="form-control" id='f_nom_subdep'>
      			</div>
      		</div>
	    <br><br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success btn_form_alta_subdep">Guardar</button>
      </div>
    </div>

  </div>
</div>



<script type="text/javascript">
	$(document).ready(function() {
		$(".tr_dep").click(function(){
			$('#departamento_actual').val($(this).attr('id_dep'))
			get_subdepartamentos();
		})
		$(document).on('change','.edit_dep',function(){
			data = $("#form_dep_"+$(this).attr('id_dep')).serialize();
			$.post('../Control_controller/act_departamento', data, function(r) {});
		})
		$(document).on('change','.edit_subdep',function(){
			$.post('../Control_controller/act_subdepartamento',{
				id_subdepartamento: $(this).attr('id_subdep'),
				nombre_subdepartamento: $(this).val()
			}, function(r) {});
		})
		$(document).on('click','#btn_alta_dep',function(){
			$("#modal_alta_departamento").modal("show");
		})
		$(document).on('click','#btn_alta_subdep',function(){
			$("#modal_alta_subdepartamento").modal("show");
		})
		$(".btn_form_alta_dep").click(function(){
			$("#form_alta_dep").submit();
		})
		$(document).on("click",".btn_baja_dep",function(){
			if(!confirm("Estas reguro de que deseas borrar este departamento?")){ return; }
			$.post('<?= site_url('Control_controller/baja_departamento')?>', 
				{id_departamento: $(this).attr('id_dep')}, 
				function(r) {
				location.reload();
			});
		})
		$(document).on("click",".btn_baja_subdep",function(){
			if(!confirm("Estas reguro de que deseas borrar este departamento?")){ return; }
			$.post('<?= site_url('Control_controller/baja_subdepartamento')?>', 
				{id_subdepartamento: $(this).attr('id_subdep')}, 
				function(r) {
				get_subdepartamentos();
			});
		})
		$(".btn_form_alta_subdep").click(function(){
			$("#modal_alta_subdepartamento").modal("hide");
			var id_dep = $("#departamento_actual").val();
			var nombre_subdep = $('#f_nom_subdep').val();
			$.post('<?= site_url('Control_controller/alta_subdepartamento')?>', {
				id_departamento: id_dep,
				nombre_subdepartamento: nombre_subdep,
			},function(){
				get_subdepartamentos();
			})
		})

		function get_subdepartamentos(){
			$.post('<?= site_url('Control_controller/get_subdepartamentos')?>', 
				{id_departamento: $("#departamento_actual").val()}, function(r) {
				$("#cont_subdepartamentos").html(r);
				$(".panel_subdep").show();
			});
		}
	});
</script>