$(document).ready(function () {

  var name = document.getElementById("name");
  var message = document.getElementById('message');
  console.log(message);
  var aideNameElt = document.getElementById("aideName");
  var aideMessageElt = document.getElementById("aideMessage");
  var couleurMsg = "";

  if (name) {
    name.addEventListener("input", function (e) {
      var name = e.target.value; // Valeur saisie dans le champ name
      var longueurName = "faible";
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
  }

  document.forms[0].addEventListener("submit", function (evenement) {
    if (name.value === "") {
      evenement.preventDefault();
      aideNameElt.textContent = "Tapez un pseudo valable pour avoir une réponse.";
      couleurMsg = "red";
      aideNameElt.style.color = couleurMsg; // Couleur du texte de l'aide
      name.focus();
    }
    console.log(name, message);
    if (message.value === "") {
      alert("Veuillez entrer une description!");
      document.formulaire.message.focus();
    }
    // if (message === null || message === "") {
    //   evenement.preventDefault();
    //   aideMessageElt.textContent = "Pensez à taper un message !";
    //   document.querySelector("message").focus();
    // }
  });

});