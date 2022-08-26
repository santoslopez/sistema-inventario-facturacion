$(document).ready(function () {
    
    //identificar numeros 
    $(".soloNumeros").keypress(function(key) {
        if ((key.charCode < 48 || key.charCode > 57)) {
            return false;
        }
    });

    $('.soloNumeros').on('keydown keypress',function(e) {
        if (e.key.length == 1) {
            if ($(this).val().length < 8 && !isNaN(parseFloat(e.key))) {
                $(this).val($(this).val() + e.key);
            }
            return false;
        }
    });


    //solo permite ingresar texto
    $(".soloTextos").keypress(function(key) {
        if ((key.charCode < 97 || key.charCode > 122)
            && (key.charCode < 65 || key.charCode > 90)
            && (key.charCode != 45)
            && (key.charCode != 241)
            && (key.charCode != 209)
            && (key.charCode != 32)



        ) {
            return false;
        }
    });

});