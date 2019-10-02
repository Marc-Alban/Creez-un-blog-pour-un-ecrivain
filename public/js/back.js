$(document).ready(function () {

    let pseudo = document.getElementById("pseudo");
    let mdp = document.getElementById("password");
    let aidePseudoElt = document.getElementById("aidePseudo");
    let aideMdpElt = document.getElementById("aideMdp");
    let regex = /^([\wéèàùûêâôë]+[\'\-\s]?[\wéèàùûêâôë]+){1,}$/;
    let couleurMsg = "";
    if (pseudo || mdp) {

        document.forms[0].addEventListener("submit", function (evenement) {

            if (pseudo.value === "") {
                evenement.preventDefault();
                aidePseudoElt.textContent = "Tapez un pseudo";
                couleurMsg = "red";
                aidePseudoElt.style.color = couleurMsg; // Couleur du texte de l'aide
                pseudo.focus();
            } else if (!regex.test(pseudo.value)) {
                evenement.preventDefault();
                aidePseudoElt.textContent = "Pas de caractère spéciaux, que alphanumérique";
                couleurMsg = "red";
                aidePseudoElt.style.color = couleurMsg; // Couleur du texte de l'aide
                pseudo.focus();
            }


            if (mdp.value === "") {
                evenement.preventDefault();
                aideMdpElt.textContent = "Tapez un mot de passe";
                couleurMsg = "red";
                aideMdpElt.style.color = couleurMsg; // Couleur du texte de l'aide
                mdp.focus();
            } else if (!regex.test(mdp.value)) {
                evenement.preventDefault();
                aideMdpElt.textContent = "Pas de caractère spéciaux, que alphanumérique";
                couleurMsg = "red";
                aideMdpElt.style.color = couleurMsg; // Couleur du texte de l'aide
                mdp.focus();
            }

        });

    }
});