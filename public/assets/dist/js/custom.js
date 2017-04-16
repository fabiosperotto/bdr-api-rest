$( document ).ready(function() {
    $('.alert').hide();

    $("#sortable").sortable({    
      stop: function(event, ui) {
        var ordens = new Array();
        $('#sortable tr').each(function() {
          ordens.push($(this).data("id"));
        });       
       $.ajax({
         type: "POST",             
         url: "tarefas/ordenar",
         data: { ordenacoes: ordens },
         success: function(data){
 
         }
       });
      }
    }).disableSelection();

    
    $('body').on('click', '#sortable .excluir', function(e) {      
      e.preventDefault();
      var id = $(this).data('id');      
      $.ajax({
       type: "POST",             
       url: "tarefas/excluir",
       data: { id: id },
       success: function(data){
        var resultado = $.parseJSON(data);              

        if(resultado.erros == 0){
          
          $('body').find($('#sortable tr[data-id="'+id+'"]')).remove();

          $(".alert" ).removeClass("alert-danger").addClass("alert-success");
          $(".alert").html('Tarefa excluida com sucesso!');
          $(".alert").show();
          $(".alert").delay(2500).fadeOut(400);

        }else{
          $(".alert" ).removeClass("alert-success").addClass("alert-danger");
          $(".alert").html('Não é possivel excluir tarefas no momento!');
          $(".alert").show();
          $(".alert").delay(2500).fadeOut(400);
        }
        
       }
     });
  });

    
});
$("#tarefaForm").submit(function(e) {
      $.ajax({
         type: "POST",             
         url: "tarefas/enviar",
         data: $("#tarefaForm").serialize(),
         success: function(data){
          var resultado = $.parseJSON(data);              

          if(resultado.erros == 0){
            
            var html = '<tr data-id="'+resultado.item.id+'"><td><small class="label bg-green">#'+resultado.item.id+'</small></td><td>'+resultado.item.titulo+'</td><td>'+resultado.item.descricao+'</td><td><a class="btn btn-danger excluir" data-id="'+resultado.item.id+'" href="#"><i class="fa fa-trash-o fa-lg"></i></a></td></tr>'
            $("#sortable").append(html);
            $(".alert" ).removeClass("alert-danger").addClass("alert-success");
            $(".alert").html('Tarefa criada com sucesso!');
            $(".alert").show();
            $(".alert").delay(2500).fadeOut(400);

          }else{
            $(".alert" ).removeClass("alert-success").addClass("alert-danger");
            $(".alert").html('Não é possivel enviar tarefas no momento!');
            $(".alert").show();
            $(".alert").delay(2500).fadeOut(400);
          }
          
         }
       });

      e.preventDefault();
  });