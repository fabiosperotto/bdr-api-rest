 <?php require_once('layout/header.php'); ?>

  <!-- Left side column. contains the logo and sidebar -->
  <?php require_once('layout/menu-esquerdo.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>      
        Tarefas
        <small>Painel de Controle</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="javascript:;"><i class="fa fa-tasks"></i> Home</a></li>
        <li class="active">Tarefas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Nova Tarefa</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
             <form role="form" id="tarefaForm">
              <div class="box-body">
                <div class="form-group">
                  <label for="titulo">Titulo</label>
                  <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Titulo" required="required">
                </div>
                <div class="form-group">
                  <label for="descricao">Descrição</label>
                  <textarea class="form-control" name="descricao" id="descricao" placeholder="Descrição" required="required"></textarea>                  
                </div>                             
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
              </div>
            </form>            
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
          <div class="alert alert-success">
  
            <strong>Success!</strong> Indicates a successful or positive action.
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tarefas</h3>              
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              
              <div class="table-responsive">            
                <table class="table table-hover table-striped tabela-sort">
                  <thead>
                    <tr>
                       <th>ID</th>
                       <th>Titulo</th>
                       <th>Descrição</th>
                       <th>Operações</th>                       
                    </tr>
                   </thead>
                  <tbody id="sortable">                  
                  <?php foreach($tarefas as $tarefa){ ?>
                  <tr data-id="<?=$tarefa->id;?>">
                    <td>
                      <small class="label bg-green">#<?=$tarefa->id;?></small>                      
                    </td>
                    <td><?=$tarefa->titulo;?></td>
                    <td>
                      <?=$tarefa->descricao;?>
                    </td>
                    <td><a class="btn btn-danger excluir" href="#" data-id="<?=$tarefa->id;?>"><i class="fa fa-trash-o fa-lg"></i></a></td>                    
                  </tr>
                  <?php } ?>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->            
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>


</script>

<?php require_once('layout/footer.php');