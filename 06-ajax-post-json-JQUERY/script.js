

$(document).ready(function () {

   
    $('#choix').on('change', function() { 
        // .ajax() est une methode de jQuery permettant de faire un appel ajax en choississant get ou post dans le "type"
        $.post('ajax.php', { id_employes: $(this).val()}, 
            function(data){
                $('#infos').html(data.resultat); 
            }
          ,
            'json' )// le type de donnée, json provoque un JSON.parse() sur la réponse
        });

        
   

   
    });
    