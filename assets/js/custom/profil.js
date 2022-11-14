//Enregistrement du nouveau mot de passe 
let profil_form = $('#profil_mdp_form');

profil_form.on('submit', function(e){
    e.preventDefault();
    
    let errors = validate($(this), user_profil_form_mdp_rules);
    errors ? set_form_error_message(errors) : (function(){
        let data = $(e.target).serializeArray();
        let promesse = request(e.target.action, 'json', true, 'POST', data);
        promesse.then(function(response) {
            (typeof response === 'object') ? set_backend_error_message(response) : notify_on_screen('Mot de passe mise à jour avec succès');
            profil_form.get(0).reset()
            $('.form-group', profil_form).removeClass('has-error')
            $('.invalid-feedback', profil_form).remove()
        });
    })();
});