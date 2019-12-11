document.addEventListener("DOMContentLoaded", function() {
    require(['jquery'], function ($) {
      //$("#id_profile_field_puestomarca").prop('disabled', true);

        var puestomarca = $("#id_department").val() + " - " + $("#id_profile_field_marca").val();
        $("#id_profile_field_puestomarca").val(puestomarca);


        $("select").change(function(){
          var puestomarca = $("#id_department").val() + " - " + $("#id_profile_field_marca").val();
          $("#id_profile_field_puestomarca").val(puestomarca);
        });

        });



});
