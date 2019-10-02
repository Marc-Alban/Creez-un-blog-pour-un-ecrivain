$(document).ready(function () {

  let name = document.getElementById("name");
  let message = document.getElementsByTagName("textarea")[0];
  let aideNameElt = document.getElementById("aideName");
  let aideMessageElt = document.getElementById("aideMessage");
  let regex = /^([\wéèàùûêâôë]+[\'\-\s]?[\wéèàùûêâôë]+){1,}$/;
  let couleurMsg = "";

  if (name || message) {
    name.addEventListener("input", function (e) {
      let name = e.target.value; // Valeur saisie dans le champ name
      let longueurName = "faible";
      couleurMsg = "red"; // Longueur faible => couleur rouge
      if (name.length >= 8) {
        longueurName = "suffisante";
        couleurMsg = "green"; // Longueur suffisante => couleur verte
      } else if (name.length >= 4) {
        longueurName = "moyenne";
        couleurMsg = "orange"; // Longueur moyenne => couleur orange
      }
      aideNameElt.textContent = "Longueur : " + longueurName; // Texte de l'aide
      aideNameElt.style.color = couleurMsg; // Couleur du texte de l'aide
    });

    document.forms[0].addEventListener("submit", function (evenement) {

      if (name.value === "") {
        evenement.preventDefault();
        aideNameElt.textContent = "Tapez un pseudo";
        couleurMsg = "red";
        aideNameElt.style.color = couleurMsg; // Couleur du texte de l'aide
        name.focus();
      } else if (!regex.test(name.value)) {
        evenement.preventDefault();
        aideNameElt.textContent = "Pas de caractère spéciaux, que alphanumérique";
        couleurMsg = "red";
        aideNameElt.style.color = couleurMsg; // Couleur du texte de l'aide
        name.focus();
      }

      if (message.value === "") {
        evenement.preventDefault();
        aideMessageElt.textContent = "Tapez un message";
        couleurMsg = "red";
        aideMessageElt.style.color = couleurMsg; // Couleur du texte de l'aide
        name.focus();
      }

    });

  }

});