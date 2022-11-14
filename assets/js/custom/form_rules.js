validate.options = {
    fullMessages: false
}

validate.validators.regex = function(value, options) {
    let strongPassword = new RegExp('^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})');
    if(!strongPassword.test(value)) return options.message;
};

validate.validators.priv_or_acces = function(value, options, key, attributes) {

    let data = $('#form_ajout_groupe').serializeArray(), keys = [];

    for(item of data){
        keys.push(item.name);
    }

    let priv = (keys.includes('priv[]') || keys.includes('droit_acces[]')),
    privTabEl = document.querySelector('#groupe_form_tabs li:last-child a'),
    privTab = new bootstrap.Tab(privTabEl);
    
    if(!priv){
        privTab.show();
        return options.message;
    }

};


  
let user_form_add_rules = {

    nom_prenoms: {
        presence: { message: 'Ce champ est obligatoire' },
    },
    email: {
        presence: { message: 'Ce champ est obligatoire' },
        email: { message: 'Ce email est invalide' },
    },
    structure: {
        presence: { message: 'Ce champ est obligatoire' },
    },
    tel: {
        presence: { message: 'Ce champ est obligatoire' },
        numericality: {
            onlyInteger: true,
            message: 'Ce champ doit est être numérique'
        }
    }
}, 

user_form_mdp_rules = {
    pass: {
        presence: { message: 'Ce champ est obligatoire' },
        equality: {
            attribute : 'confirme',
            message: 'Mots de passe non identiques',
        },
    },
    confirme: {
        presence: { message: 'Ce champ est obligatoire' },
        equality: {
            attribute : 'pass',
            message: 'Mots de passe non identiques',
        },
        // regex: {
        //     message: "Le mot de passe doit être de 8 caractères minimum et doit contenir au moins :<ul><li> une lettre minuscule;</li><li> une lettre majuscule;</li><li> un chiffre;</li><li> un caractère spécial.</li></ul>"
        // }

    }
},

groupe_form_add_rules = {
    nom: {
        presence: { message: 'Ce champ est obligatoire' }
    },
    priv: {
        priv_or_acces: { message: "Vous devez choisir au moins un privilège ou droit d'accès"}
    }
},

user_profil_form_mdp_rules = {
    actuel_pass: {
        presence: { message: 'Ce champ est obligatoire' }
    },
    nouveau_pass: {
        presence: { message: 'Ce champ est obligatoire' },
        equality: {
            attribute : 'confirm_pass',
            message: 'Mots de passe non identiques',
        },
    },
    confirm_pass: {
        presence: { message: 'Ce champ est obligatoire' },
        equality: {
            attribute : 'nouveau_pass',
            message: 'Mots de passe non identiques',
        },
        // regex: {
        //     message: "Le mot de passe doit être de 8 caractères minimum et doit contenir au moins :<ul><li> une lettre minuscule;</li><li> une lettre majuscule;</li><li> un chiffre;</li><li> un caractère spécial.</li></ul>"
        // }
    }
}, 

type_depense_form_rules = {
    libelle: {
        presence: { message: 'Ce champ est obligatoire' }
    },
    description: {
        presence: { message: 'Ce champ est obligatoire' }
    }
}, 

produit_form_rules = {
    libelle: {
        presence: { message: 'Ce champ est obligatoire' }
    }
},

structure_form_rules = {
    nom: {
        presence: { message: 'Ce champ est obligatoire' }
    },
    administrateur: {
        presence: { message: 'Ce champ est obligatoire' }
    }
},

depense_form_rules = {
    type_depense: {
        presence: { message: 'Ce champ est obligatoire' }
    },
    prix_unitaire: {
        presence: { message: 'Ce champ est obligatoire' },
        numericality: {
            numericality: true,
            message: 'Valeur saisie invalide'
        },
    },
    mode_paiement: {
        presence: { message: 'Le mode de paiement est obligatoire' }
    },
    qte: {
        presence: { message: 'Ce champ est obligatoire' },
        numericality: {
            numericality: true,
            message: 'Valeur saisie invalide'
        },
    },
    echeance: {
        presence: { message: 'Ce champ est obligatoire' }
    }
},

vente_form_rules = {
    produit: {
        presence: { message: 'Ce champ est obligatoire' }
    },
    prix_unitaire: {
        presence: { message: 'Ce champ est obligatoire' },
        numericality: {
            numericality: true,
            message: 'Valeur saisie invalide'
        },
    },
    qte: {
        presence: { message: 'Ce champ est obligatoire' },
        numericality: {
            numericality: true,
            message: 'Valeur saisie invalide'
        },
    },
    date_vente: {
        presence: { message: 'Ce champ est obligatoire' }
    },
    mode_paiement: {
        presence: { message: 'Le mode de paiement est obligatoire' }
    }
},

date_recette = {
    date_recette: {
        presence: { message: 'Ce champ est obligatoire' }
    },
}