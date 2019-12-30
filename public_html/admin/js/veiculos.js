$(function(){
  $('#campoMarca').change(function(){
    var marcaId = $(this).val()

    if(marcaId != ""){
      $('#campoModelo').html("<option value=''> carregando </option>");

      $.getJSON("modelos.ajax.php?id="+marcaId, function(modelos){
        $('#campoModelo').html("<option value=''> selecione o modelo </option>");  

        modelos.forEach(function(modelo){
          var option = $("<option></option>")
          option.attr("value", modelo.id)
          option.text(modelo.nome)
          $('#campoModelo').append(option)
        })
      })
    } else{
      $('#campoModelo').html("<option value=''> selecione a marca </option>");
    }
  })

  $('#campoCor').change(function(){
    var cor = $(this).val()
    //alert(cor)

    if(cor == "Outra"){
      var input = $("<input />")
      input.attr("class", "form-control")
      input.attr("name", "cor")
      input.insertAfter("#campoCor")
      input.focus()
      $("#campoCor").remove()
      input.attr("id", "campoCor")
    }
  })
})