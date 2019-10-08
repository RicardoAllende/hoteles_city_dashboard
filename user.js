document.addEventListener("DOMContentLoaded", function() {
    require(['jquery'], function ($) {
        var firstname_ = $('#id_firstname');
        var lastname_ = $('#id_lastname');
        $(('#id_firstname, #id_lastname')).on('input', function(){
            firstname = string_to_slug( firstname_.val().substr(0, 1));
            lastname = string_to_slug(lastname_.val());
            default_username = firstname + lastname + get_formatted_date();
            $('#id_username').val(default_username);
            $('#id_newpassword').val(default_username);
        });
        var today = new Date();
        function generate_username(first, last){

        }
        function get_formatted_date(){
            formatted_date = "";
            
            year = today.getFullYear().toString().substr(2);
            formatted_date += year;
            
            month = today.getMonth();
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