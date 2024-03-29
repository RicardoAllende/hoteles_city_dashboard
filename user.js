document.addEventListener("DOMContentLoaded", function() {
    require(['jquery'], function ($) {
        $('.ocultar-elemento').hide();
        var firstname_ = $('#id_firstname');
        var lastname_ = $('#id_lastname');
        $(('#id_firstname, #id_lastname')).on('input', function(){
            firstname = string_to_slug(firstname_.val());
            initial_firstname = firstname.substr(0, 1);
            middlename = format_middlename(lastname_.val());
            // lastname = format_email(lastname);
            autogenerated = initial_firstname + middlename;
            default_username = autogenerated + get_formatted_date();
            default_email = default_username + "@hotelescity.com";
            $('#id_username').val(default_username);
            $('#id_newpassword').val(default_username);
            $('#id_email').val(default_email);
        });
        function format_middlename(email){
            if(email == ""){
                return email;
            }
            email = string_to_slug(email);
            pieces = email.split('_');
            response = "";
            middlenameCompleted = false;
            for (var index = 0; index < pieces.length; index++) {
                var current_word = pieces[index];
                if(!middlenameCompleted){
                    middlenameCompleted = current_word.length > 2 && current_word != 'del';
                    response += current_word;
                }
            }
            return response;
        }
        var today = new Date();
        function get_formatted_date(){
            formatted_date = "";

            year = today.getFullYear().toString().substr(2);
            formatted_date += year;

            month = today.getMonth();
            month++; // January is 0
            if(month < 10){
                formatted_date += ('0' + month);
            }else{
                formatted_date += month;
            }

            day = today.getDate();
            if(day < 10){
                formatted_date += ('0' + day);
            }else{
                formatted_date += day;
            }
            return formatted_date;
        }

        function string_to_slug (str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            var from = "àáäâèéëêìíïîòóöôùúüûñç·/-,:;";
            var to   = "aaaaeeeeiiiioooouuuunc______";
            for (var i=0, l=from.length ; i<l ; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '_') // collapse whitespace and replace by -
                .replace(/-+/g, '_'); // collapse dashes

            return str;
        }
    });
});
